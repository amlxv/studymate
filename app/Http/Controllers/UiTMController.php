<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Campus;
use App\Models\Faculty;

class UiTMController extends Controller
{
    public static string $iCressBaseUrl = "https://simsweb4.uitm.edu.my/estudent/class_timetable/";
    public static string $myStudentBaseUrl = "https://cdn.uitm.edu.my/jadual/baru/{studentId}.json";
    protected string $studentId;
    protected string $courseCode;
    protected string $group;
    protected string $campusCode;
    protected string|null $facultyCode;

    /**
     * @param string $studentId
     * @param string $courseCode
     * @param string $group
     * @param string $campusCode
     * @param string|null $facultyCode
     */
    public function __construct(string $studentId, string $courseCode, string $group, string $campusCode, string $facultyCode = null)
    {
        $this->studentId = $studentId;
        $this->courseCode = $courseCode;
        $this->group = $group;
        $this->campusCode = $campusCode;
        $this->facultyCode = $facultyCode;
    }

    /**
     * Get the timetables.
     *
     * @return array
     */
    public function getTimetables()
    {
        $timetables = [];

        if ($this->registerICressIdentifier()) {
            $timetables = $this->getTimetableFromICress();
        }

        if ($this->registerMyStudentUri()) {
            $data = $this->getTimetablesFromMyStudent();

            if ($timetables && $data) {
                $extraKeys = array_keys(array_diff_key($data[0], $timetables[0]));
                $timetables = collect($timetables)
                    ->map(function ($timetable, $timetableIndex) use (&$extraKeys, $data) {
                        collect($extraKeys)
                            ->each(function ($extraKey) use (&$timetable, $timetableIndex, $data) {
                                $timetable = array_merge($timetable, [$extraKey => $data[$timetableIndex][$extraKey]]);
                            });
                        return $timetable;
                    })->toArray();
            }

            if (!$timetables) $timetables = $data;
        }

        return $timetables;
    }

    /**
     * Get & set the random id1 & id2 value
     * for related the course from iCress.
     *
     * @return bool
     */
    protected function registerICressIdentifier()
    {
        try {
            if (!$this->courseCode && !$this->campusCode &&
                ($this->campusCode == "B" && !$this->facultyCode)) {
                throw new Exception("Missing required information.");
            }

            $url = self::$iCressBaseUrl . 'index_result.cfm';

            $data = [
                "search_campus" => $this->campusCode,
                "search_faculty" => $this->facultyCode,
                "search_course" => $this->courseCode
            ];

            $response = Http::asForm()
                ->replaceHeaders(['Referer' => self::$iCressBaseUrl . "index.htm"])
                ->post($url, $data);

            if (!Str::contains($response->body(), "Record Founds") ||
                Str::contains($response->body(), "No Record Founds")) {
                throw new Exception("No records found for the given information.");
            }

            $crawler = new Crawler($response->body());
            $crawler = $crawler->filter('#btn1');

            $result = $crawler->getNode(0)->attributes->item(1)->nodeValue;

            if (!$result) {
                throw new Exception("No result found for this course code.");
            }

            preg_match("/id1=([^']*)&id2=([^']*)/", $result, $matches);

            self::$iCressBaseUrl = self::$iCressBaseUrl . "index_tt.cfm?" . $matches[0];
        } catch (Exception) {
            return false;
        }

        return true;
    }

    /**
     * Set the full path url to the
     * myStudent timetables resource.
     *
     * @return bool
     */
    protected function registerMyStudentUri()
    {
        try {
            if (!$this->studentId && !$this->courseCode && !$this->group) {
                throw new Exception("Missing required information.");
            }
            self::$myStudentBaseUrl = str_replace("{studentId}", $this->studentId, self::$myStudentBaseUrl);
        } catch (Exception) {
            return false;
        }

        return true;
    }

    /**
     * Get the timetables from ICress.
     *
     * @return array
     */
    protected function getTimetableFromICress()
    {
        try {
            $response = Http::timeout(10)->get(self::$iCressBaseUrl);

            if (!$response->ok()) {
                throw new Exception("Cannot connect to the server.");
            }

            $data = [];

            $crawler = new Crawler($response->body());

            $crawler->filter('tr')->slice(1)->each(function (Crawler $node) use (&$data) {

                $children = $node->children();

                $DAYTIME = 1;
                $GROUP = 2;
                $VENUE = 5;

                $dayTimeRaw = $children->getNode($DAYTIME)->nodeValue;
                preg_match('/(.+)(\(.+\))/', $dayTimeRaw, $matches);

                $times = str_replace(["(", ")", " ", "AM", "PM"], "", explode("-", $matches[2]));

                $day = Str::lower($matches[1]);
                $timeStart = $times[0];
                $timeEnd = $times[1];
                $group = $children->getNode($GROUP)->nodeValue;
                $venue = $children->getNode($VENUE)->nodeValue;

                $data[] = [
                    "course" => $this->courseCode,
                    "group" => $group,
                    "day" => $day,
                    "venue" => $venue,
                    "time_start" => $timeStart,
                    "time_end" => $timeEnd
                ];
            });

            return array_values(
                collect($data)
                    ->filter(fn($item) => $item['group'] == $this->group)
                    ->toArray()
            );
        } catch (Exception) {
            return [];
        }
    }

    /**
     * Get timetables from MyStudent.
     *
     * @return array
     */
    protected function getTimetablesFromMyStudent()
    {
        try {
            $response = Http::timeout(10)->get(self::$myStudentBaseUrl);

            if (!$response->ok()) {
                throw new Exception("Cannot connect to the server.");
            }

            $response = collect($response->json())
                ->filter(fn($item) => $item)
                ->flatMap(fn($item) => [Str::lower($item['hari']) => $item['jadual']])
                ->toArray();

            $data = [];

            collect($response)->each(function ($item, $day) use (&$data) {
                collect($item)->each(function ($class) use ($day, &$data) {
                    $times = str_replace(["(", ")", " ", "AM", "PM"], "", explode("-", $class['masa']));
                    $timeStart = $times[0];
                    $timeEnd = $times[1];
                    $group = $class['groups'];
                    $venue = $class['bilik'];
                    $lecturer = $class['lecturer'];
                    $courseName = $class['course_desc'];

                    $data[] = [
                        "course" => $class['courseid'],
                        "course_name" => $courseName,
                        "group" => $group,
                        "day" => $day,
                        "venue" => $venue,
                        "time_start" => $timeStart,
                        "time_end" => $timeEnd,
                        "lecturer" => $lecturer,
                    ];
                });
            });

            return array_values(
                collect($data)
                    ->filter(fn($item) => $item['group'] == $this->group
                        && $item['course'] == $this->courseCode)
                    ->toArray()
            );
        } catch (Exception) {
            return [];
        }
    }

    /**
     * Register the campuses in database.
     *
     * @return string
     */
    public static function registerCampuses()
    {
        try {
            $response = Http::timeout(10)->get(self::$iCressBaseUrl . "combo_select_campus.txt");

            $result = self::handleCampusesAndFaculties($response);

            if (Campus::query()->truncate() &&
                !Campus::query()->insert($result->toArray())
            ) {
                throw new Exception("Something went wrong when updating the campuses.");
            }

            return "Successfully fetched and updated the campuses.";
        } catch (Exception $error) {
            return $error->getMessage();
        }
    }

    /**
     * Register the faculties in database.
     *
     * @return array
     */
    public static function registerFaculties()
    {
        try {
            $response = Http::timeout(10)->get(self::$iCressBaseUrl . "combo_select_faculty.txt");

            $result = self::handleCampusesAndFaculties($response);

            if (Faculty::query()->truncate() &&
                !Faculty::query()->insert($result->toArray())
            ) {
                throw new Exception("Something went wrong when updating the faculties.");
            }

            return ["status" => "success", "message" => "Successfully fetched and updated the faculties."];
        } catch (Exception $error) {
            return ["status" => "error", "message" => $error->getMessage()];
        }
    }


    /**
     * Handle the data extraction of
     * the campuses and faculties.
     *
     * @param \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response $response
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public static function handleCampusesAndFaculties(\GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response $response): \Illuminate\Support\Collection
    {
        if (!$response->ok()) {
            throw new Exception("Cannot connect to the server.");
        }

        $result = str_replace(["\r", "\n", "\t"], "", $response->body());
        $result = explode("<br>", $result);
        $result = collect($result)->map(fn($item) => trim($item));
        $result = collect($result)->filter(fn($item) => $item && !Str::startsWith($item, "==="));

        return collect($result)->map(function ($item) {
            $raw = explode("-", $item);
            $code = trim($raw[0]);
            $name = trim($raw[1]);

            if (count($raw) > 2) {
                unset($raw[0]);
                $name = trim(implode("-", $raw));
            }

            return ["code" => $code, "name" => $name];
        });
    }
}

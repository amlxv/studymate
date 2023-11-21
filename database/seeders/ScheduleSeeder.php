<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                "title" => "Weekly Meeting",
                "description" => "Join the meeting",
                "day" => "sunday",
                "time_start" => "01:25:00",
                "time_end" => "14:47:00",
                "type" => "class",
            ],
            [
                "title" => "Renew License",
                "description" => "Renew the driver license at the nearest JPJ.",
                "date" => "2023-10-03",
                "time_start" => "19:02:00",
                "time_end" => "21:33:00",
                "type" => "activity",
            ],
            [
                "title" => "Ethical Class",
                "description" => "Join the online ethical class",
                "day" => "wednesday",
                "time_start" => "21:22:00",
                "time_end" => "22:37:00",
                "type" => "class",
            ],
            [
                "title" => "My Birthday",
                "description" => "This is the day that the day that my birthday day.",
                "date" => "2023-10-26",
                "time_start" => "15:23:00",
                "time_end" => "22:11:00",
                "type" => "activity",
            ],
            [
                "title" => "Final Paper",
                "description" => "Good luck!",
                "date" => "2023-10-16",
                "time_start" => "13:57:00",
                "time_end" => "14:54:00",
                "type" => "activity",
            ],
            [
                "title" => "Pay bills",
                "description" => "Settle all the utilities bills.",
                "date" => "2023-10-16",
                "time_start" => "10:33:00",
                "time_end" => "16:00:00",
                "type" => "activity",
            ],
            [
                "title" => "Tesla V3",
                "description" => "Launching the new Tesla model V3.",
                "date" => "2023-10-16",
                "time_start" => "10:33:00",
                "time_end" => "16:00:00",
                "type" => "activity",
            ],
            [
                "title" => "Laravel",
                "description" => "Laravel for beginner online course.",
                "day" => "wednesday",
                "time_start" => "20:22:00",
                "time_end" => "22:37:00",
                "type" => "class",
            ],
            [
                "title" => "Android",
                "description" => "Android for beginner f2f course.",
                "day" => "monday",
                "time_start" => "20:25:00",
                "time_end" => "23:47:00",
                "type" => "class",
            ],
            [
                "title" => "Flutter",
                "description" => "Learn flutter.",
                "day" => "monday",
                "time_start" => "21:25:00",
                "time_end" => "23:47:00",
                "type" => "class",
            ],
            [
                "title" => "Quick Test",
                "description" => "Lecturer: Bob\nChapter: 2 - 5\nCarry Mark: 40\n\nDuration: 30 Minutes only",
                "date" => "2023/10/10",
                "time_start" => "20:25:00",
                "time_end" => "23:47:00",
                "type" => "activity",
            ],
            [
                "title" => "Project Formulation",
                "description" => "Attend the class for CSP650.",
                "day" => "friday",
                "time_start" => "15:00:00",
                "time_end" => "16:00:00",
                "type" => "class",
            ],
            [
                "title" => "Technology Entrepreneurship",
                "description" => "Attend the class for ENT600.",
                "day" => "wednesday",
                "time_start" => "21:22:00",
                "time_end" => "22:37:00",
                "type" => "class",
            ],
            [
                "title" => "Netflix",
                "description" => "Stop the netflix subscription.",
                "date" => "2023-10-31",
                "time_start" => "15:00:00",
                "time_end" => "16:00:00",
                "type" => "activity",
            ],
        ];

//        foreach ($schedules as $schedule) {
//            Schedule::factory()->create($schedule);
//        }
//
//        Schedule::factory()
//            ->count(30)
//            ->sequence(fn(Sequence $sequence) => [
//                "day" => Factory::create()->randomElement([
//                    'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'
//                ])
//            ])
//            ->create(["type" => "class"]);
//
//        Schedule::factory()
//            ->count(100)
//            ->sequence(fn(Sequence $sequence) => [
//                "date" => Factory::create()->date()
//            ])
//            ->create(["type" => "activity"]);
    }
}

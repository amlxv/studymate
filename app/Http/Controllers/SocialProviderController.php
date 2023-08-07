<?php

namespace App\Http\Controllers;

use App\Models\SocialProvider;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialProviderController extends Controller
{

    protected string $provider;
    protected \Laravel\Socialite\Contracts\User $socialUser;
    protected array $data;

    /**
     * Redirect the user to the social provider.
     *
     * @param string $provider
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * The redirect from the social provider.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    public function callback(string $provider)
    {
        try {
            $this->provider = $provider;

            // Instantiate user (a new users if not exist)
            $this->getSocialUser()->collectUserAndSocialData()->registerOrLoginUser();

            // Redirect the user to homepage
            return redirect()->route('home');

        } catch (Exception $e) {
            info($e);
            return redirect()->route('login')->with('status', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Extract the response from social provider.
     *
     * @return $this
     * @throws Exception
     */
    public function getSocialUser()
    {
        if (empty($this->provider)) {
            throw new  Exception("Something went wrong. Please try again later.");
        }

        $this->socialUser = Socialite::driver($this->provider)->user();
        return $this;
    }

    /**
     * Collect the required data for eloquent.
     *
     * @return $this
     * @throws Exception
     */
    public function collectUserAndSocialData()
    {
        if (empty($this->provider) || empty($this->socialUser)) {
            throw new  Exception("Something went wrong. Please try again later.");
        }

        $this->data = [
            'user' => [
                'name' => $this->socialUser->getName(),
                'email' => $this->socialUser->getEmail(),
                'avatar' => $this->socialUser->getAvatar(),
                'email_verified_at' => now()
            ],
            'provider' => [
                'id' => $this->socialUser->getId(),
                'name' => $this->provider,
                'token' => $this->socialUser->token,
                'refresh_token' => $this->socialUser->refreshToken ?? null,
            ]
        ];

        return $this;
    }

    /**
     * Verify the user is not duplicate.
     *
     * @return boolean|User
     * @throws Exception
     */
    public function verifyUnregisteredUser()
    {
        if (empty($this->data)) {
            throw new  Exception("Something went wrong. Please try again later.");
        }

        $user = User::where('email', $this->data['user']['email'])->first();

        if ($user && !$user->socialProvider()->exists()) {
            throw new Exception('Please sign in using another method.');
        };

        if ($user && in_array($this->data['provider']['id'], $user->socialProvider()->get()->map(fn($item) => $item['id'])->toArray())) {
            return $user;
        }

        return true;
    }

    /**
     * Handle user register and login
     *
     * @return void
     * @throws Exception
     */
    public function registerOrLoginUser()
    {
        $isUserUnregistered = $this->verifyUnregisteredUser();
        ($isUserUnregistered instanceof User) ? $this->logUserIn($isUserUnregistered) : $this->registerUser();
    }

    /**
     * Register the user & their social
     * provider into the database.
     *
     * @return void
     * @throws Exception
     */
    public function registerUser()
    {
        $user = User::create($this->data['user']);

        if (!$user) {
            throw new Exception("Something went wrong when creating a user.");
        }

        $userSocialProvider = SocialProvider::query()->create(array_merge($this->data['provider'], ['user_id' => $user->id]));

        if (!$userSocialProvider) {
            throw new Exception("Something went wrong went creating user's social provider.");
        }

        $this->logUserIn($user);
    }

    /**
     * Log the user into the current session.
     *
     * @param $user
     * @return User
     * @throws Exception
     */
    public function logUserIn($user)
    {
        if (empty($user)) {
            throw new Exception("Something went wrong when logging the user.");
        }

        Auth::login($user);
        return $user;
    }
}

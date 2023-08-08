<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function hitBasePath()
    {
        $user = Auth::user();
        return !$user ? $this->handleGuest() : $this->handleUser($user);
    }

    /**
     * @return Response
     */
    public function handleGuest()
    {
        return Inertia::render('Guest/Index');
    }

    public function handleUser(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if ($user->isAdmin()) {
            return Inertia::render('Admin/Home/Index');
        }

        if ($user->isStudent()) {
            return Inertia::render('Student/Home/Index');
        }

        return Inertia::render('Student/Home/Welcome');
    }
}

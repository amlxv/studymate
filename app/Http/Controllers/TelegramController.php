<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTelegramRequest;
use App\Models\Telegram;
use Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class TelegramController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('telegram')->redirect();
    }

    public function callback(StoreTelegramRequest $request)
    {
        $data = array_merge(
            $request->except("id"),
            [
                "chat_id" => $request['id'],
                "user_id" => Auth::id()
            ]
        );

        if (Telegram::updateOrCreate(["user_id" => Auth::id()], $data)) {
            return redirect()->route('setting.index')->with([
                "status" => "Successfully added Telegram into your account."
            ]);
        }

        return redirect()->route('setting.index')->with(["status" => [
            "error" => "Something went wrong when integrating with Telegram."
        ]]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

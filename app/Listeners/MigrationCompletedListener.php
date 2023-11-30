<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Database\Events\MigrationsEnded;

class MigrationCompletedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MigrationsEnded $event): void
    {
        \App\Http\Controllers\UiTMController::registerCampuses();
        \App\Http\Controllers\UiTMController::registerFaculties();
    }
}

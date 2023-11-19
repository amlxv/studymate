<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * The date is optional. If there is a day selected, date should not
         * be specified as it will consider to repeat every that day in a week.
         *
         * Put the specific date, or select the day to repeat every week.
         *
         * E.g:
         * - Specific date: Task dateline (once)
         * - Select day: Class timetable (every week)
         */
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('day', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])->nullable();
            $table->date('date')->nullable();
            $table->time('time_start');
            $table->time('time_end');
            $table->enum('type', ['class', 'activity']);
            $table->boolean('remind');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};

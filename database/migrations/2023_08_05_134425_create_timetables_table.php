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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreignId('preference_id')->constrained();
            $table->string('title');
            $table->string('description');
            $table->foreignId('day_id')->constrained();
            $table->date('date')->nullable();
            $table->time('time_start');
            $table->time('time_end');
//            $table->boolean('repeat')->default('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};

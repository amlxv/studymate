<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'amlxv (Student)',
            'email' => 'student@amlxv.com',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'amlxv (Admin)',
            'email' => 'admin@amlxv.com',
            'role' => 'admin'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Asrol Arshad',
            'email' => 'asrol.arshad@gmail.com',
        ]);

        \App\Models\User::factory(10)->create();

        $this->call([
            ScheduleSeeder::class,
        ]);
    }
}

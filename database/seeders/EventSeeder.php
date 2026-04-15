<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Get an admin user (creator)
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return; // stop if no admin exists
        }

        Event::create([
            'title' => 'Music Concert',
            'description' => 'Live music concert with famous artists',
            'location' => 'New York',
            'event_datetime' => now()->addDays(5),
            'total_seats' => 100,
            'available_seats' => 100,
            'created_by' => $admin->id,
        ]);

        Event::create([
            'title' => 'Tech Conference',
            'description' => 'Latest trends in technology',
            'location' => 'San Francisco',
            'event_datetime' => now()->addDays(10),
            'total_seats' => 200,
            'available_seats' => 200,
            'created_by' => $admin->id,
        ]);

        Event::create([
            'title' => 'Workshop on Laravel',
            'description' => 'Hands-on Laravel training',
            'location' => 'London',
            'event_datetime' => now()->addDays(3),
            'total_seats' => 50,
            'available_seats' => 50,
            'created_by' => $admin->id,
        ]);
    }
}
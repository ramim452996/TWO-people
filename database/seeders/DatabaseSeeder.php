<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        if (\App\Models\Task::count() === 0) {
            \App\Models\Task::create([
                'title' => 'Design System & UI Components',
                'description' => 'Finalize typography, color tokens, and responsive layout for the core dashboard.',
                'assigned_to' => 'Ramim',
                'priority' => 'High',
                'status' => 'Completed',
                'due_date' => now()->subDays(2),
            ]);

            \App\Models\Task::create([
                'title' => 'API Integration & Authentication',
                'description' => 'Set up database schema, migrations, and session management.',
                'assigned_to' => 'Sarah Connor',
                'priority' => 'High',
                'status' => 'Completed',
                'due_date' => now()->subDays(1),
            ]);

            \App\Models\Task::create([
                'title' => 'Implement Status Distribution Pie Chart',
                'description' => 'Integrate Chart.js to visually display task progress and metrics on dashboard.',
                'assigned_to' => 'Ramim',
                'priority' => 'Medium',
                'status' => 'Completed',
                'due_date' => now(),
            ]);

            \App\Models\Task::create([
                'title' => 'Quarterly Performance Review Report',
                'description' => 'Compile team task delivery stats and export metrics for office review.',
                'assigned_to' => 'Alex Miller',
                'priority' => 'High',
                'status' => 'In Progress',
                'due_date' => now()->addDays(2),
            ]);

            \App\Models\Task::create([
                'title' => 'Server Security Audit & Backup Strategy',
                'description' => 'Review file permissions, SQLite backup configuration, and error logging.',
                'assigned_to' => 'David Kim',
                'priority' => 'Medium',
                'status' => 'Pending',
                'due_date' => now()->addDays(5),
            ]);

            \App\Models\Task::create([
                'title' => 'Legacy System Data Migration',
                'description' => 'Migrate archived project records into the task tracker system.',
                'assigned_to' => 'Elena Rostova',
                'priority' => 'High',
                'status' => 'Pending',
                'due_date' => now()->subDays(3), // Overdue for demo
            ]);
        }
    }
}

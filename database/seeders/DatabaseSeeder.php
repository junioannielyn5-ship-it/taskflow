<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(\Database\Seeders\RoleSeeder::class);

        $defaultRoleUsers = [
            ['name' => 'System Admin', 'email' => 'admin@test.com', 'role' => 'admin'],
            ['name' => 'Project Manager', 'email' => 'pm@test.com', 'role' => 'project_manager'],
            ['name' => 'Team Lead', 'email' => 'lead@test.com', 'role' => 'lead'],
            ['name' => 'Member User', 'email' => 'member@test.com', 'role' => 'member'],
        ];

        foreach ($defaultRoleUsers as $seedUser) {
            User::query()->updateOrCreate(
                ['email' => $seedUser['email']],
                [
                    'name' => $seedUser['name'],
                    'password' => 'password',
                    'role' => $seedUser['role'],
                ]
            );
        }

        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            User::factory()->make([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ])->toArray()
        );

        $this->call(\Database\Seeders\TaskManagementDemoSeeder::class);
        $this->call(\Database\Seeders\TaskSeeder::class);
        $this->call(\Database\Seeders\AutomationRuleSeeder::class);
        $this->call(\Database\Seeders\ChatbotKnowledgeSeeder::class);
    }
}

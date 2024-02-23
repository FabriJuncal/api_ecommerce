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

        $this->call(RolesTableSeeder::class);

        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'surname' => 'admin',
            'email' => 'admin@admin.com',
            "password" => "admin",
            'type_user' => 2,
            'role_id' => 1
        ]);
    }
}

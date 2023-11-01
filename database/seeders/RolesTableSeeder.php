<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica si el registro ya existe para evitar duplicados
        if (!Role::where('name', 'ADMINISTRADOR GENERAL')->exists()) {
            // Inserta un nuevo registro en la tabla "roles"
            Role::create([
                'name' => 'ADMINISTRADOR GENERAL',
            ]);
        }
    }
}

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
        // Crea o encuentra el rol "ADMINISTRADOR GENERAL"
        Role::firstOrCreate(['name' => 'ADMINISTRADOR GENERAL']);

        // Crea o encuentra el rol "USUARIO ESTANDAR"
        Role::firstOrCreate(['name' => 'USUARIO ESTANDAR']);
    }
}

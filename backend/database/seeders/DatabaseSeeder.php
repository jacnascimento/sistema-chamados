<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primeiro cria o usuário administrador
        $this->call([
            AdminUserSeeder::class,
        ]);

        // Depois cria as categorias (que dependem do usuário admin)
        $this->call([
            CategorySeeder::class,
        ]);
    }
}

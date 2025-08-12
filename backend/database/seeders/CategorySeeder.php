<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Suporte Técnico',
            'Financeiro',
            'Estoque',
            'Comercial',
            'Compras',
            'Melhoria'
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
                'created_by' => 1, // ID do usuário administrador
            ]);
        }
    }
}

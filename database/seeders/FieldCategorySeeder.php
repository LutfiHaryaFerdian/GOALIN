<?php

namespace Database\Seeders;

use App\Models\FieldCategory;
use Illuminate\Database\Seeder;

class FieldCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Futsal',       'slug' => 'futsal',      'icon' => '⚽', 'description' => 'Lapangan futsal indoor dan outdoor'],
            ['name' => 'Basket',       'slug' => 'basket',      'icon' => '🏀', 'description' => 'Lapangan basket standar'],
            ['name' => 'Badminton',    'slug' => 'badminton',   'icon' => '🏸', 'description' => 'Lapangan bulu tangkis indoor'],
            ['name' => 'Tenis',        'slug' => 'tenis',       'icon' => '🎾', 'description' => 'Lapangan tenis standar'],
            ['name' => 'Voli',         'slug' => 'voli',        'icon' => '🏐', 'description' => 'Lapangan bola voli'],
            ['name' => 'Sepak Bola',   'slug' => 'sepak-bola',  'icon' => '⚽', 'description' => 'Lapangan sepak bola 11 orang'],
        ];

        foreach ($categories as $category) {
            FieldCategory::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}

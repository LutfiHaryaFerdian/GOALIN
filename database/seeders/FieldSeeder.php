<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\FieldCategory;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        $owner1 = User::where('email', 'owner1@goalin.test')->first();
        $owner2 = User::where('email', 'owner2@goalin.test')->first();

        $futsal    = FieldCategory::where('slug', 'futsal')->first();
        $basket    = FieldCategory::where('slug', 'basket')->first();
        $badminton = FieldCategory::where('slug', 'badminton')->first();
        $tenis     = FieldCategory::where('slug', 'tenis')->first();

        $jakarta    = Location::where('city', 'Jakarta')->first();
        $bandung    = Location::where('city', 'Bandung')->first();
        $surabaya   = Location::where('city', 'Surabaya')->first();
        $yogyakarta = Location::where('city', 'Yogyakarta')->first();

        $fields = [
            [
                'name'          => 'Arena Futsal Senayan',
                'slug'          => 'arena-futsal-senayan',
                'description'   => 'Lapangan futsal premium dengan rumput sintetis berkualitas tinggi. Dilengkapi AC dan pencahayaan profesional.',
                'price_per_hour'=> 150000,
                'status'        => 'active',
                'category_id'   => $futsal?->id,
                'location_id'   => $jakarta?->id,
                'owner_id'      => $owner1?->id,
                'facilities'    => ['parkir', 'toilet', 'mushola', 'wifi', 'ac', 'kantin'],
                'capacity'      => 10,
            ],
            [
                'name'          => 'GOR Basket Bandung',
                'slug'          => 'gor-basket-bandung',
                'description'   => 'Gedung olahraga basket dengan lantai parket berkualitas internasional. Cocok untuk pertandingan dan latihan.',
                'price_per_hour'=> 200000,
                'status'        => 'active',
                'category_id'   => $basket?->id,
                'location_id'   => $bandung?->id,
                'owner_id'      => $owner1?->id,
                'facilities'    => ['parkir', 'toilet', 'mushola', 'wifi', 'loker'],
                'capacity'      => 10,
            ],
            [
                'name'          => 'Badminton Hall Surabaya',
                'slug'          => 'badminton-hall-surabaya',
                'description'   => 'Hall badminton indoor dengan 6 lapangan, lantai PVC anti-slip, dan pencahayaan LED standar turnamen.',
                'price_per_hour'=> 80000,
                'status'        => 'active',
                'category_id'   => $badminton?->id,
                'location_id'   => $surabaya?->id,
                'owner_id'      => $owner2?->id,
                'facilities'    => ['parkir', 'toilet', 'wifi', 'kantin'],
                'capacity'      => 4,
            ],
            [
                'name'          => 'Tennis Court Jogja',
                'slug'          => 'tennis-court-jogja',
                'description'   => 'Lapangan tenis outdoor dengan permukaan hard court. View pegunungan yang indah dan udara sejuk.',
                'price_per_hour'=> 120000,
                'status'        => 'active',
                'category_id'   => $tenis?->id,
                'location_id'   => $yogyakarta?->id,
                'owner_id'      => $owner2?->id,
                'facilities'    => ['parkir', 'toilet', 'mushola'],
                'capacity'      => 4,
            ],
            [
                'name'          => 'Futsal Pro Jakarta Selatan',
                'slug'          => 'futsal-pro-jakarta-selatan',
                'description'   => 'Lapangan futsal modern di jantung Jakarta Selatan. Rumput sintetis premium dan sistem scoring digital.',
                'price_per_hour'=> 180000,
                'status'        => 'active',
                'category_id'   => $futsal?->id,
                'location_id'   => $jakarta?->id,
                'owner_id'      => $owner2?->id,
                'facilities'    => ['parkir', 'toilet', 'mushola', 'wifi', 'kantin', 'loker'],
                'capacity'      => 10,
            ],
        ];

        foreach ($fields as $fieldData) {
            Field::firstOrCreate(
                ['slug' => $fieldData['slug']],
                $fieldData
            );
        }
    }
}

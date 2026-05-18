<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Pusat Jakarta',    'city' => 'Jakarta',    'province' => 'DKI Jakarta',     'address' => 'Jakarta Pusat, DKI Jakarta'],
            ['name' => 'Kota Bandung',     'city' => 'Bandung',    'province' => 'Jawa Barat',       'address' => 'Bandung, Jawa Barat'],
            ['name' => 'Kota Surabaya',    'city' => 'Surabaya',   'province' => 'Jawa Timur',       'address' => 'Surabaya, Jawa Timur'],
            ['name' => 'Kota Yogyakarta',  'city' => 'Yogyakarta', 'province' => 'DI Yogyakarta',    'address' => 'Yogyakarta, DI Yogyakarta'],
            ['name' => 'Kota Medan',       'city' => 'Medan',      'province' => 'Sumatera Utara',   'address' => 'Medan, Sumatera Utara'],
            ['name' => 'Kota Makassar',    'city' => 'Makassar',   'province' => 'Sulawesi Selatan', 'address' => 'Makassar, Sulawesi Selatan'],
            ['name' => 'Kota Semarang',    'city' => 'Semarang',   'province' => 'Jawa Tengah',      'address' => 'Semarang, Jawa Tengah'],
        ];

        foreach ($locations as $loc) {
            Location::firstOrCreate(['city' => $loc['city']], $loc);
        }
    }
}

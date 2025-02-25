<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SmartphonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('smartphones')->insert([
            [
                'id' => 67,
                'name' => 'Realme C15',
                'price' => 1900000,
                'processor' => 'DualCore',
                'storage' => 64,
                'ram' => 4,
                'camera' => 8,
                'screen' => 'Full HD',
                'battery' => '5000 - 6000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 68,
                'name' => 'Realme C20',
                'price' => 2200000,
                'processor' => 'DualCore',
                'storage' => 32,
                'ram' => 2,
                'camera' => 8,
                'screen' => 'Full HD',
                'battery' => '4000 - 5000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 69,
                'name' => 'Realme C25',
                'price' => 1499000,
                'processor' => 'DualCore',
                'storage' => 64,
                'ram' => 4,
                'camera' => 28,
                'screen' => 'Full HD',
                'battery' => '5000 - 6000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 70,
                'name' => 'Oppo A16K',
                'price' => 1400000,
                'processor' => 'QuadCore',
                'storage' => 32,
                'ram' => 4,
                'camera' => 13,
                'screen' => 'Full HD',
                'battery' => '4000 - 5000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 72,
                'name' => 'Oppo A54',
                'price' => 900000,
                'processor' => 'QuadCore',
                'storage' => 64,
                'ram' => 6,
                'camera' => 13,
                'screen' => 'Full HD',
                'battery' => '4000 - 5000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 73,
                'name' => 'Oppo A57',
                'price' => 1300000,
                'processor' => 'QuadCore',
                'storage' => 64,
                'ram' => 4,
                'camera' => 13,
                'screen' => 'Full HD',
                'battery' => '5000 - 6000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 74,
                'name' => 'Samsung Galaxy A03 Core',
                'price' => 2300000,
                'processor' => 'HexaCore',
                'storage' => 32,
                'ram' => 2,
                'camera' => 8,
                'screen' => 'HD+',
                'battery' => '5000 - 6000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 75,
                'name' => 'Samsung Galaxy A13',
                'price' => 800000,
                'processor' => 'HexaCore',
                'storage' => 32,
                'ram' => 6,
                'camera' => 50,
                'screen' => 'HD+',
                'battery' => '5000 - 6000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 76,
                'name' => 'Samsung Galaxy A04S',
                'price' => 1200000,
                'processor' => 'HexaCore',
                'storage' => 32,
                'ram' => 4,
                'camera' => 48,
                'screen' => 'HD+',
                'battery' => '4000 - 5000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 77,
                'name' => 'Vivo Y21S',
                'price' => 980000,
                'processor' => 'OctaCore',
                'storage' => 64,
                'ram' => 4,
                'camera' => 48,
                'screen' => 'Full HD',
                'battery' => '4000 - 5000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 78,
                'name' => 'Vivo Y21A',
                'price' => 1100000,
                'processor' => 'OctaCore',
                'storage' => 32,
                'ram' => 4,
                'camera' => 13,
                'screen' => 'Full HD',
                'battery' => '4000 - 5000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 79,
                'name' => 'Vivo Y22',
                'price' => 975000,
                'processor' => 'OctaCore',
                'storage' => 128,
                'ram' => 6,
                'camera' => 48,
                'screen' => 'Full HD',
                'battery' => '4000 - 5000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 93,
                'name' => 'ass',
                'price' => 123,
                'processor' => 'QuadCore',
                'storage' => 128,
                'ram' => 4,
                'camera' => 13,
                'screen' => '4K',
                'battery' => '2000 - 3000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 94,
                'name' => 'ass',
                'price' => 123,
                'processor' => 'DualCore',
                'storage' => 32,
                'ram' => 3,
                'camera' => 8,
                'screen' => 'Full HD',
                'battery' => '1000 - 2000',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}


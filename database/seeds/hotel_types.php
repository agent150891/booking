<?php

use Illuminate\Database\Seeder;

class hotel_types extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hotel_types')->insert([
            [
            'hotel_type' => 'Котедж',
            ],
            [
            'hotel_type' => 'База відпочинку',
            ],
            [
            'hotel_type' => 'Готель',
            ],
            [
            'hotel_type' => 'Приватний сектор',
            ],
        ]);
    }
}

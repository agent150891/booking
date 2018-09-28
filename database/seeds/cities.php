<?php

use Illuminate\Database\Seeder;

class cities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            [
            'city' => 'с.Світязь',
            'gps_alt'=>23.86508242279046,
            'gps_lng'=>51.48369220136
            ],
            [
            'city' => 'смт.Шацьк',
            'gps_alt'=>23.92276064544671,
            'gps_lng'=>51.49582373194757
            ],
            [
            'city' => 'с.Підманове',
            'gps_alt'=>23.813240686950618,
            'gps_lng'=>51.46364405495712
            ],
            [
            'city' => 'с.Омельне',
            'gps_alt'=>23.88087526947015,
            'gps_lng'=>51.455515363410406
            ],
            [
            'city' => 'с.Пульмо',
            'gps_alt'=>23.782899538574153,
            'gps_lng'=>51.51356095068042
            ],
            [
            'city' => 'с.Згорани',
            'gps_alt'=>23.97649065643304,
            'gps_lng'=>51.36139539986644
            ],
            [
            'city' => 'ур.Гряда',
            'gps_alt'=>23.890896002349788,
            'gps_lng'=>51.514682651032025
            ],
        ]);
    }
}

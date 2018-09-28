<?php

use Illuminate\Database\Seeder;

class paid_types extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('paid_types')->insert([
          ['type'=>'VIP'],
          ['type'=>'TOP'],
          ['type'=>'Подовжити платне'],
          ['type'=>'Подовжити безкоштовне'],
        ]);
    }
}

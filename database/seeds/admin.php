<?php

use Illuminate\Database\Seeder;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = DB::table('users')->insertGetId(['name'=>'admin', 'password'=>'ADMIN', 'role'=>2]);
        DB::table('phones')->insert(['phone'=>'777777777777', 'user_id'=>$id]);
    }
}

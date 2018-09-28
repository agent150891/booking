<?php

use Illuminate\Database\Seeder;

class paid_schemes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paid_schemes')->insert([
          ['name'=>'VIP 30','days'=>30,'price'=>50,
          'ptype_id'=>DB::table('paid_types')->where('type','VIP')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'VIP 60','days'=>60,'price'=>100,'ptype_id'=>DB::table('paid_types')
            ->where('type','VIP')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'VIP 90','days'=>90,'price'=>150,'ptype_id'=>DB::table('paid_types')
            ->where('type','VIP')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'TOP 30','days'=>30,'price'=>25,'ptype_id'=>DB::table('paid_types')
            ->where('type','TOP')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'TOP 60','days'=>60,'price'=>50,'ptype_id'=>DB::table('paid_types')
            ->where('type','TOP')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'TOP 90','days'=>90,'price'=>75,'ptype_id'=>DB::table('paid_types')
            ->where('type','TOP')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'Продлить платное 30','days'=>30,'price'=>25,'ptype_id'=>DB::table('paid_types')
            ->where('type','Продлить платное')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'Продлить платное 60','days'=>60,'price'=>50,'ptype_id'=>DB::table('paid_types')
            ->where('type','Подовжити платне')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'Продлить платное 90','days'=>90,'price'=>75,'ptype_id'=>DB::table('paid_types')
            ->where('type','Подовжити платнее')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'Продлить бесплатное 7','days'=>7,'price'=>10,'ptype_id'=>DB::table('paid_types')
            ->where('type','Подовжити безкоштовне')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'Продлить бесплатное 14','days'=>14,'price'=>20,'ptype_id'=>DB::table('paid_types')
            ->where('type','Подовжити безкоштовне')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
          ['name'=>'Продлить бесплатное 30','days'=>30,'price'=>30,'ptype_id'=>DB::table('paid_types')
            ->where('type','Подовжити безкоштовне')->value('id'),
            'created_at'=>date('Y-m-d H:i:s',time()),'updated_at'=>date('Y-m-d H:i:s',time())],
        ]);
    }
}

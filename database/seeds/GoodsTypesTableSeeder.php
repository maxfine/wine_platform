<?php
use Illuminate\Database\Seeder;
use App\Models\GoodsType;

class GoodsTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('goods_types')->delete();

        $datas = array(
            array(
                'type_name'      => '电脑',
                'enabled'      => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('goods_types')->insert( $datas );
    }

}

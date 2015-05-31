<?php
use Illuminate\Database\Seeder;
use App\Models\GoodsAttr;
use App\Models\GoodsType;
use App\Models\Attribute;

class GoodsAttrsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('goods_attrs')->delete();

        $datas = array(
            array(
                'goods_id' => 1,
                'attr_id' => 3,
                'attr_value' => '800*400',
                'attr_price' => 100,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'goods_id' => 1,
                'attr_id' => 3,
                'attr_value' => '1200*800',
                'attr_price' => 100,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
        );
        DB::table('goods_attrs')->insert( $datas );
    }

}

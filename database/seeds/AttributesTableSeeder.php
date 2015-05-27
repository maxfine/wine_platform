<?php
use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('attributes')->delete();

        $_v = ['红色','白色','黑色'];
        $_v2 = [21,23,27];
        $datas = array(
            array(
                'type_id'    => 1,
                'attr_name'  => '颜色', //属性名
                'attr_input_type'  => '1', //录入方式:0手工录入,1单选,2多选
                'attr_type'  => '1', //是否可选,0唯一值,1单选,2多选
                'attr_value' => serialize($_v), //全部选值
                'attr_index' => '0', //是否索引
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'type_id'    => 1,
                'attr_name'  => '尺寸', //属性名
                'attr_input_type'  => '1', //录入方式:0手工录入,1单选,2多选
                'attr_type'  => '1', //是否可选,0唯一值,1单选,2多选
                'attr_value' => serialize($_v2), //全部选值
                'attr_index' => '0', //是否索引
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('attributes')->insert( $datas );
    }

}

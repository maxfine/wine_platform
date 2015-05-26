<?php
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('brands')->delete();

        $datas = array(
            array(
                'brand_name'      => '联想',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('brands')->insert($datas);
    }

}

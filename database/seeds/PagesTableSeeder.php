<?php
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Page;
use Faker\Factory as Faker;

class PagesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create('zh_CN');
        $adminUser = User::where('name','=','admin')->first();
        $adminUserId = isset($adminUser) ? $adminUser->id : 0;
        $publicPath = app('path.public');
        $dirPath = $publicPath.'/uploads/images/fakers';
        $urlDirPath = '/uploads/images/fakers';

        DB::table('pages')->delete();
        foreach(range(1, 100) as $index){
            Page::create(
                [
                    'title' => 'znyesmaxfine单页'.$index,
                    'thumb' => URL($urlDirPath.'/'.$faker->image($dirPath, 640, 480, null, false)),
                    'slug'  => '',
                    'content' => $faker->text,
                    'user_id' => $adminUserId,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ]
            );
        }
    }
}

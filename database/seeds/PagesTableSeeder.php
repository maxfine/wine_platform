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

        DB::table('pages')->delete();
        foreach(range(1, 100) as $index){
            Page::create(
                [
                    'title' => $faker->title,
                    'thumb' => $faker->imageUrl(640, 480),
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

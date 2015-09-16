<?php
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PosterTheme;
use App\Models\Template;
use Faker\Factory as Faker;

class PosterThemesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create('zh_CN');
        $user = User::where('name','=','user')->first();
        $userId = isset($user) ? $user->id : 0;
        $template = Template::first();
        $templateId = isset($template) ? $template->id : 0;
        $publicPath = app('path.public');
        $dirPath = $publicPath.'/uploads/images/fakers';
        $urlDirPath = '/uploads/images/fakers';
        $end_at = (new DateTime())->modify('+1 Year');

        DB::table('poster_themes')->delete();
        foreach(range(1, 3) as $index){
            PosterTheme::create(
                [
                    'user_id' => $userId,
                    'template_id' => $templateId,
                    'site_url' => $faker->url,
                    'status' => 1,
                    'image100x450' => URL($urlDirPath.'/'.$faker->image($dirPath, 100, 450, null, false)),
                    'image1000x90' => URL($urlDirPath.'/'.$faker->image($dirPath, 1000, 90, null, false)),
                    'end_at' => $end_at,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ]
            );
        }
    }
}

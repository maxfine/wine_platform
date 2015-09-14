<?php
use Illuminate\Database\Seeder;
use App\Models\Template;

class TemplatesTableSeeder extends Seeder {

    public function run()
    {
        Template::create(['template' => 'poster.themes.baidu']);
        Template::create(['template' => 'poster.themes.haosou']);
        Template::create(['template' => 'poster.themes.sogou']);
    }
}

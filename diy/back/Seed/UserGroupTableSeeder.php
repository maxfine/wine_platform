<?php
use Illuminate\Database\Seeder;
use App\Models\UserGroup;

class UserGroupTableSeeder extends Seeder {

    public function run()
    {
        DB::table('user_groups')->delete();

        $names =[
                '游客',
                '新注册会员',
                '邮件认证会员',
                '中级会员',
                '高级会员',
                '禁止访问',
                '买家',
                '卖家',
                '买家&卖家',
        ];
        foreach($names as $name){
            UserGroup::create([
                'name' => $name,
            ]);

        }
    }

}

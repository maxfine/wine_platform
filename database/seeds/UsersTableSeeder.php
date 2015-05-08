<?php
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $users = array(
            array(
                'name'      => 'admin',
                'email'      => 'max_fine@qq.com',
                'password'   => Hash::make('admin'),
                //'confirmed'   => 1,
                'remember_token' => md5(microtime().Config::get('env.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name'      => 'user',
                'email'      => '1526469221@qq.com',
                'password'   => Hash::make('user'),
                //'confirmed'   => 1,
                'remember_token' => md5(microtime().Config::get('env.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('users')->insert( $users );
    }

}

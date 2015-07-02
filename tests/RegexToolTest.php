<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/2
 * Time: 10:40
 */
class RegexToolTest extends TestCase {

    public function setUp()
    {
        parent::setUp();
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testIsEmail()
	{
        $regexTool = new \App\Repositories\RegexTool(false);
        $this->assertEquals(true, $regexTool->isEmail('max_fine@qq.com'));
	}

    public function testGoodsIndex(){
        //$response =  $this->call('GET', '/admin/goods/');
        /**
        $user = \App\Models\User::where(['name' => 'admin'])->first();
        $this->be($user);
        $this->seed('DatabaseSeeder');
        $response = $this->call('GET', '/admin/goods');
        $view = $response->original;
        $this->assertEquals(true, $view['goods'][0] instanceof \App\Models\Goods);
        ****/
    }

}
<?php

class MyTest extends TestCase {

    public function setUp()
    {
        parent::setUp();

        $this->testFile = array(
            'name'=>'2012-04-20 21.13.42.jpg',
            'tmp_name'=>'C:\wamp\tmp\php8D20.tmp',
            'type'=>'image/jpeg',
            'size'=>1472190,
            'error'=>0
        );
    }

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(200, $response->getStatusCode());
	}

    public function testGoodsIndex(){
        //$response =  $this->call('GET', '/admin/goods/');
        $user = \App\Models\User::where(['name' => 'admin'])->first();
        $this->be($user);
        $this->seed('DatabaseSeeder');
        $response = $this->call('GET', '/admin/goods');
        $view = $response->original;
        $this->assertEquals(true, $view['goods'][0] instanceof \App\Models\Goods);
    }

}

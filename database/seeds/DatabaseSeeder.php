<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        /**
        $this->call('UsersTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('BrandsTableSeeder');
		$this->call('GoodsTypesTableSeeder');
		$this->call('AttributesTableSeeder');
		$this->call('GoodsAttrsTableSeeder');
        $this->call('PagesTableSeeder');
        $this->command->info('Pages table seeded!');
        $this->call('TemplatesTableSeeder');
        **/
        $this->call('PosterThemesTableSeeder');
	}

}

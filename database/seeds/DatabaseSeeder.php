<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*$this->call(UsersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(\Idib\Suits\Seeds\SuitCategoriesTableSeeder::class);
        $this->call(\Idib\Suits\Seeds\SuitSubCategoriesTableSeeder::class);
        $this->call(\Idib\Suits\Seeds\SuitAccentTableSeeder::class);
        $this->call(\Idib\Suits\Seeds\SuitAccentAttributeTableSeeder::class);
        $this->call(\Idib\Suits\Seeds\SuitStyleTableSeeder::class);
        $this->call(\Idib\Suits\Seeds\SuitStyleAttributeTableSeeder::class);*/
        $this->call(\Idib\Suits\Seeds\SuitAccentAttributeTableSeeder::class);
    }
}

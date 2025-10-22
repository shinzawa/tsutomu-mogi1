<?php

namespace Database\Seeders;

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
        $this->call(ItemsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ItemCategoryTableSeeder::class);
        $this->call(ProfilesTableSeeder::class);
        $this->call(ItemUserTableSeeder::class);
        $this->call(NicesTableSeeder::class);
        $this->call(BuyItemsTableSeeder::class);
        $this->call(ExhibitItemsTableSeeder::class);
    }
}

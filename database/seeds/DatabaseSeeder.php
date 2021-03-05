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
        $this->call(LangaugeSeed::class);
         $this->call(OrdersTableSeeder::class);
        $this->call(attributesTableSeeder::class);
        $this->call(CuponsTableSeeder::class);
        $this->call(UserTableSeed::class);
        $this->call(CategoriesTableSeed::class);
        $this->call(BrandsTableSeed::class);
        $this->call(ManufacturersTableSeed::class);
        $this->call(PagesTableSeeder::class);
        $this->call(ModulesTableSeed::class);
//        $this->call(PackagesTableSeed::class);
        $this->call(CountriesSeeder::class);
        $this->call(StatesSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(ProductsTableSeed::class);
        $this->call(InventoriesTableSeed::class);

        // $this->call(ProductsTableSeeder::class);
        # $this->call(ProductTranslationsTableSeeder::class);
        # $this->call(ProductImagesTableSeeder::class);
        # $this->call(ProductCategoriesTableSeeder::class);
    }
}

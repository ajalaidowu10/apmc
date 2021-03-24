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
        $this->call([
                      StatusSeeder::class,
                      ItemSeeder::class,
                      ModuleSeeder::class,
                      PermissionSeeder::class,
                      RoleSeeder::class,
                      AdminSeeder::class,
                      CrdrSeeder::class,
                      ParentGroupcodeSeeder::class,
                      GroupcodeSeeder::class, 
                      AccountTypeSeeder::class,
                      TransactypeSeeder::class,
                      AccountSeeder::class,
                      CashbankTypeSeeder::class,
                      PaymentTypeSeeder::class,

        ]);
    }
}

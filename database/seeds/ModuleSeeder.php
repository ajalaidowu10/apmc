<?php

use Illuminate\Database\Seeder;
use App\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // create modules
      Module::create(['name' => "Master", 'icon'=>"mdi-apps"]);
      Module::create(['name' => "Data Entry", 'icon'=>"mdi-clipboard-text"]);
      Module::create(['name' => "Reports", 'icon'=>"mdi-file-chart"]);
      Module::create(['name' => "Enquiry", 'icon'=>"mdi-book-information-variant"]);
      Module::create(['name' => "Utility", 'icon'=>"mdi-cog"]);
      Module::create(['name' => "Dashboard", 'icon'=>"mdi-view-dashboard"]);
      

    }
}

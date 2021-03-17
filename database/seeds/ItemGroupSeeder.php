<?php

use Illuminate\Database\Seeder;
use App\ItemGroup;
class ItemGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemGroup::create(['name'=>'Drinks']);
        ItemGroup::create(['name'=>'Break-Fast']);
        ItemGroup::create(['name'=>'Accompniments']);
        ItemGroup::create(['name'=>'Appetizers']);
        ItemGroup::create(['name'=>'Soup']);
        ItemGroup::create(['name'=>'Salad']);
        ItemGroup::create(['name'=>'Main Course (VEG)']);
        ItemGroup::create(['name'=>'Main Course (NON-VEG)']);
        ItemGroup::create(['name'=>'Rice']);
        ItemGroup::create(['name'=>'Dal']);
        ItemGroup::create(['name'=>'Chapati']);
        ItemGroup::create(['name'=>'Sweets']);

    }
}

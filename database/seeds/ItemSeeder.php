<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Onion = new Item (['name' => 'Onion', 'unit' => 10, 'weight_pb' => 70, 'status_id' => 1]);
        $Onion->save();
        $Onion->item_exps()->create(['enter_date' => '2021-03-24', 'comm' => 6.50, 'p_hamali' => 5.40, 'b_hamali' => 9.05, 'p_levy' => 2.28, 'b_levy' => 3.83, 'apmc' => 0.80, 'map_levy' => 0.0137, 'discount' => 1, 'tolai' => 1, 'tds' =>3.75]);

        $Garlic = new Item (['name' => 'Garlic', 'unit' => 10, 'weight_pb' => 70, 'status_id' => 1]);
        $Garlic->save();
        $Garlic->item_exps()->create(['enter_date' => '2021-03-24', 'comm' => 6.50, 'p_hamali' => 5.40, 'b_hamali' => 9.05, 'p_levy' => 2.28, 'b_levy' => 3.83, 'apmc' => 0.80, 'map_levy' => 0.0137, 'discount' => 1, 'tolai' => 1, 'tds' =>3.75]);


        $Potato = new Item (['name' => 'Potato', 'unit' => 10, 'weight_pb' => 70, 'status_id' => 1]);
        $Potato->save();
        $Potato->item_exps()->create(['enter_date' => '2021-03-24', 'comm' => 6.50, 'p_hamali' => 5.40, 'b_hamali' => 9.05, 'p_levy' => 2.28, 'b_levy' => 3.83, 'apmc' => 0.80, 'map_levy' => 0.0137, 'discount' => 1, 'tolai' => 1, 'tds' =>3.75]);



    }
}

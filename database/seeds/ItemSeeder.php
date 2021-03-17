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
       Item::create(['item_group_id' => 1, 'name' => 'Kokam Sarbat', 'price' =>  60.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Taak(ButterMilk) Plain', 'price' =>  50.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Taak(ButterMilk) Masala', 'price' =>  60.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Choice of Lassi', 'price' =>  80.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Lime Water', 'price' =>  50.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Water Bottle', 'price' =>  30.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Mango Juice', 'price' =>  50.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Soda Bottle(700ml)', 'price' =>  40.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Thums Up(600ml)', 'price' =>  70.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Thums Up(250ml)', 'price' =>  40.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Sprite (600ml)', 'price' =>  70.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 1, 'name' => 'Sprite (250ml)', 'price' =>  40.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Tea', 'price' =>  30.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Black tea', 'price' =>  30.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Coffee', 'price' =>  40.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Milk', 'price' =>  50.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Corn-flax', 'price' =>  110.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Kanda pohe', 'price' =>  100.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Upma', 'price' =>  100.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Choice of paratha', 'price' =>  130.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Plain omelette', 'price' =>  130.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Masala Omelette', 'price' =>  150.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Deep Bread Omelette', 'price' =>  130.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 2, 'name' => 'Boiled Egg', 'price' =>  80.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Masala Papad', 'price' =>  50.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Fry papad', 'price' =>  35.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Khekda bhaji', 'price' =>  110.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Moong dal pakoda', 'price' =>  110.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Onion pakoda', 'price' =>  100.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Kanda bhaji', 'price' =>  100.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Bread pakoda', 'price' =>  150.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Cheese pakoda', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Paneer pakoda', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Aloo bhaji', 'price' =>  150.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 3, 'name' => 'Finger chips (H/M)', 'price' =>  110.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Paneer chilly dry', 'price' =>  250.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Cheese corn balls', 'price' =>  250.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Veg crispy', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Chic ken Chilly', 'price' =>  250.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Chickeri lolipop', 'price' =>  280.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'KolhapuriTawa Fry', 'price' =>  350.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Mutton sukka', 'price' =>  350.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Chicken sukka', 'price' =>  300.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Mutton ukkad', 'price' =>  330.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Chicken ukkad', 'price' =>  280.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 4, 'name' => 'Chicken fry', 'price' =>  310.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Tomato Soup', 'price' =>  130.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Munchow soup veg', 'price' =>  140.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Munchow soup Non veg ', 'price' =>  160.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Cream of mushroom Veg', 'price' =>  170.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Cream of mushroom Non veg', 'price' =>  190.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Cream of tomato', 'price' =>  130.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Lemon coriander', 'price' =>  130.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Cream of vegeta bl es', 'price' =>  130.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Mutton alni soup', 'price' =>  110.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 5, 'name' => 'Chicken alni soup', 'price' =>  100.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Fresh garden salad', 'price' =>  80.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Kuchumber', 'price' =>  80.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Curd onion sa lad', 'price' =>  60.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Kimchi salad', 'price' =>  110.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Cucumber Cantonese', 'price' =>  150.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Cucumber cilantro sa lad', 'price' =>  150.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Dahi', 'price' =>  30.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Veg raita', 'price' =>  100.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Cucumber raita', 'price' =>  110.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 6, 'name' => 'Pineapple Raita', 'price' =>  120.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Kaju curry', 'price' =>  280.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Paneer m/s', 'price' =>  250.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Batata sukhi bhaji', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Bharleli bhendi', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Bharleli vangi', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Shev bhaji', 'price' =>  160.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Methichi bhaji', 'price' =>  120.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Pitla', 'price' =>  150.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Kolhapuri mix veg', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Til wali bhendi', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Thecha', 'price' =>  110.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Akkha Masoor Amti', 'price' =>  210.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 7, 'name' => 'Veg Kofta Curry', 'price' =>  250.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Kolhapuri kharda mutton', 'price' =>  400.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Malwani kothimbir mutton', 'price' =>  400.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Solapuri mutton masala', 'price' =>  400.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Vidharbha waradi mutton', 'price' =>  400.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Mutton Adraki', 'price' =>  400.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Mutton rassa handi', 'price' =>  450.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Mutton rassa handi', 'price' =>  900.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Kolhapuri kharda chicken', 'price' =>  300.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Chicken kolhapuri', 'price' =>  300.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Malwani kothimbir chicken', 'price' =>  300.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Solapuri chicken m/s', 'price' =>  300.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Vidharbha waradi chicken', 'price' =>  300.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Chicken rassa handi', 'price' =>  350.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Chicken rassa handi', 'price' =>  700.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Egg curry', 'price' =>  250.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 8, 'name' => 'Egg m/s', 'price' =>  250.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 9, 'name' => 'Steam Rice', 'price' =>  130.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 9, 'name' => 'Jeera Rice', 'price' =>  150.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 9, 'name' => 'Lemon Rice', 'price' =>  140.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 9, 'name' => 'lndrayani Bhat', 'price' =>  150.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 9, 'name' => 'Masala bhat', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 9, 'name' => 'Tawa Veg pulao', 'price' =>  200.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 9, 'name' => 'Veg Biryani', 'price' =>  250.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 9, 'name' => 'chicken Biryani', 'price' =>  350.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 9, 'name' => 'Mutton biryani', 'price' =>  450.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 10, 'name' => 'Varan', 'price' =>  110.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 10, 'name' => 'Fhodniche varan', 'price' =>  140.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 10, 'name' => 'Dal Fry', 'price' =>  140.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 10, 'name' => 'Dal tadka', 'price' =>  160.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 11, 'name' => 'Chappati', 'price' =>  25.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 11, 'name' => 'Butter chapati', 'price' =>  30.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 11, 'name' => 'Bhakari', 'price' =>  30.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 12, 'name' => 'Shrikhand', 'price' =>  100.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 12, 'name' => 'Amra khand', 'price' =>  100.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 12, 'name' => 'Guiab jamun', 'price' =>  90.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 12, 'name' => 'Dahi-sakhar', 'price' =>  50.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 12, 'name' => 'Gajar Halwa', 'price' =>  150.00 , 'status_id' => 1 ]);
       Item::create(['item_group_id' => 12, 'name' => 'Moong Dal Halwa', 'price' =>  150.00 , 'status_id' => 1 ]);

    }
}

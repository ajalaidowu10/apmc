<?php

use Illuminate\Database\Seeder;
use App\RoomGroup;

class RoomGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomGroup::create([
            'name' => 'Delux', 
            'descp' => 'Well-furnished and designed rooms feature air-conditioning, ergonomic work area, and LED HD TV. It comes with fine curtains, safety deposit box and tea and coffee amenities along with a mini-fridge. Attached bathrooms include free toiletries and a shower with cold and hot water facilities. Guests can make use of community table, tea trolley, business center, laundry, and ironing services. The 24- hour front desk provides car rental services. The hotel features state-of-the-art meeting spaces and open-air dining space',
            'room_price' => 2500,
            'extra_bed_price' => 1250,
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\BookingOrder;
use App\User;
use App\RoomGroup;

class BookingOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookingOrder::create([
              'user_id' => User::all()->random()->id,
              'room_group_id' => RoomGroup::all()->random()->id,
              'checkin' => '2020-01-01',
              'checkout' => '2020-01-02',
              'total_room' => 1,
              'total_extra_bed' => 2,
        ]);
        BookingOrder::create([
              'user_id' =>  User::all()->random()->id,
              'room_group_id' => RoomGroup::all()->random()->id,
              'checkin' => '2021-01-01',
              'checkout' => '2021-01-03',
              'total_room' => 2,
              'total_extra_bed' => 1,
        ]);
        BookingOrder::create([
              'user_id' =>  User::all()->random()->id,
              'room_group_id' => RoomGroup::all()->random()->id,
              'checkin' => '2021-01-03',
              'checkout' => '2021-01-05',
              'total_room' => 1,
              'total_extra_bed' => 1,
        ]);
        BookingOrder::create([
              'user_id' =>  User::all()->random()->id,
              'room_group_id' => RoomGroup::all()->random()->id,
              'checkin' => '2021-01-02',
              'checkout' => '2021-01-02',
              'total_room' => 2,
              'total_extra_bed' => 3,
        ]);

    }
}

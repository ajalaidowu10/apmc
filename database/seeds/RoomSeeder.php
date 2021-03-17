<?php

use Illuminate\Database\Seeder;
use App\Room;
use App\RoomGroup;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Room::create([
              'room_group_id' => RoomGroup::all()->random()->id,
              'name' => 'Room 101',
              'intercom' => '001',
          ]);

        Room::create([
              'room_group_id' => RoomGroup::all()->random()->id,
              'name' => 'Room 102',
              'intercom' => '002',
          ]);

        Room::create([
              'room_group_id' => RoomGroup::all()->random()->id,
              'name' => 'Room 103',
              'intercom' => '003',
          ]);

        Room::create([
              'room_group_id' => RoomGroup::all()->random()->id,
              'name' => 'Room 104',
              'intercom' => '004',
          ]);

        Room::create([
              'room_group_id' => RoomGroup::all()->random()->id,
              'name' => 'Room 105',
              'intercom' => '005',
          ]);
    }
}

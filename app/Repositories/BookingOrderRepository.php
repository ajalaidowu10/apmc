<?php 
  namespace App\Repositories;
  use App\BookingOrder;
  use App\Room;
  use DB;

  /**
   * BookingOrderRepository
   */
  class BookingOrderRepository
  {
    
    public function allReservedRoom(int $room_group_id, string $date_from, string $date_to, int $booking_id = 0): int
    {
      $total_rooms = BookingOrder::where('room_group_id', '=', $room_group_id)
                                  ->where('date_from', '>=', $date_from)
                                  ->where('date_to', '<=', $date_to)
                                  ->where('is_booked', '=', 1)
                                  ->where('status_id', '=', 4);
    if ($booking_id != 0) 
    {
        $total_rooms = $total_rooms->where('id', '!=', $booking_id);
    } 
    

      $total_rooms = $total_rooms->sum('total_room');

      return $total_rooms;
    }

    public function allRoom(int $room_group_id): int
    {
      $total_rooms = Room::where('room_group_id', '=', $room_group_id)
                          ->count();
      
      return $total_rooms;
    }
  }
?>
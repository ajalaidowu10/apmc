<?php

namespace App\Http\Controllers;
use App\Repositories\BookingOrderRepository;
use App\Http\Requests\BookingOrderRequest;
use App\Http\Resources\BookingOrderResource;
use App\Http\Resources\BookingOrderItemResource;
use App\Http\Resources\RoomResource;
use App\User;
use App\BookingOrder;
use App\BookingOrderItem;
use App\RoomGroup;
use App\Room;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingOrderMail;
use App\Mail\EditBookingOrderMail;
use App\Ledger;
use Auth;
use DB;
use DateTime;

use Illuminate\Http\Request;

class BookingOrderController extends Controller
{
    protected $order;

    function __construct(BookingOrderRepository $order)
    {
      $this->order = $order;
      $this->middleware('JWT', ['except' => ['search', 'store']]);
    }

    public function search(int $room_group_id, string $date_from, string $date_to, int $total_room, int $booking_id = 0)
    {
      $date1 = new DateTime($date_from);
      $date2 = new DateTime($date_to);
      
      if ($date1 >= $date2) 
      {
        return ['is_avail' => false, 'message' =>'Invalid Checkin and Checkout Date', 'room_price' => 0, 'extra_bed_price' => 0];
      } 

      $get_all_rooms = $this->order->allRoom($room_group_id);

      $get_reservation = $this->order->allReservedRoom($room_group_id, $date_from, $date_to, $booking_id);

      $remaining_room = $get_all_rooms - $get_reservation;

      $is_avail = ($remaining_room - $total_room >= 0) ? true : false ;

      $room_group = RoomGroup::find($room_group_id);
      $room_price = $room_group->room_price;
      $extra_bed_price = $room_group->extra_bed_price;

      if ($is_avail) {
        $message = "ROOM AVAILABLE";
        
      } else {
        $message = "Selected rooms is not Available we have {$remaining_room} room left";
      }


      return ['is_avail' => $is_avail, 'message' => $message, 'room_price' => $room_price, 'extra_bed_price' => $extra_bed_price];
      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $get_booking = BookingOrder::where('is_booked', 1)
                                    ->where('stage_id', 1)
                                    ->latest()->get();

      return BookingOrderResource::collection($get_booking);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingOrderRequest $request)
    {
        $room_group_id = $request->input('room_group_id');

        $room_group = RoomGroup::find($room_group_id)->toArray();

        $request->merge($room_group);

        $is_booked = ['is_booked' => 1];
        $request->merge($is_booked);

        $is_confirmed = ['status_id' => 3];
        $request->merge($is_confirmed);

        $roomsinfos = $request->input('rooms_info');
        $get_user = User::find($request->input('user_id'));

        DB::beginTransaction();
          try 
          {
              $booking_order = $get_user->booking_orders()
                               ->create($request->all())
                               ->booking_order_items()
                               ->createMany($roomsinfos);

              $get_new = BookingOrder::latest('created_at')->first();

              Mail::to($get_new->user->email)->send(new BookingOrderMail($get_new));
             
           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

      return response(['orderid' => $get_new->id], Response::HTTP_CREATED);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\BookOrder  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(BookingOrder $booking)
    {
      return new BookingOrderResource($booking);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookingOrder  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(BookingOrderRequest $request, BookingOrder $booking)
    {
        $room_group = RoomGroup::find($booking->room_group_id)->get(['room_price', 'extra_bed_price'])->toArray();
        $request->merge(array_shift($room_group));

        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);
        
        $is_booked = ['is_booked' => 1];
        $request->merge($is_booked);

        $is_confirmed = ['status_id' => 4];
        $request->merge($is_confirmed);

        $roomsinfos = $request->input('rooms_info');

        DB::beginTransaction();
          try 
          {
              BookingOrderItem::where('booking_order_id', $booking->id)->delete();
              $booking->update($request->except(['rooms_info']));
              $booking->booking_order_items()->createMany($roomsinfos);
           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

      return response(['orderid' => $booking->id], Response::HTTP_ACCEPTED);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookingOrder  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingOrder $booking)
    {
      $booking->delete();
      return response(null, Response::HTTP_NO_CONTENT);
    }




    public function avalRoom()
    {
      $get_aval_room = Room::where('status_id', 2)->latest()->get();
      return RoomResource::collection($get_aval_room);
    }

    public function getCheckin()
    {
      $get_booking = BookingOrderItem::where('status_id', 2)->latest()->get();
      return BookingOrderItemResource::collection($get_booking);
    }

    public function getInvoice()
    {
      $get_booking = BookingOrder::where('stage_id', 2)
                                    ->orWhere('stage_id', 3)
                                    ->latest()->get();
      return BookingOrderResource::collection($get_booking);
    }



    public function getCheckout()
    {
      $get_booking = BookingOrderItem::where('status_id', 5)->latest()->get();
      return BookingOrderItemResource::collection($get_booking);
    }

    public function getRoomInfo(BookingOrder $booking)
    {
      $get_booking = BookingOrderItem::where('booking_order_id', $booking->id)->get();

      return BookingOrderItemResource::collection($get_booking);
    }

    public function printInvoice(BookingOrder $booking)
    {
      $get_booking = BookingOrderItem::where('booking_order_id', $booking->id)->get();
      return view('print.booking_invoice', ['data' => $get_booking]);
    }


    public function storeCheckin(Request $request)
    {
        $get_room = Room::find($request->input('room_id'));
        $get_booking = BookingOrderItem::find($request->input('id'));
        $now_date = date('Y-m-d');
        // $now_date = date('Y-m-d', time() + 86400);

        if ($get_booking->booking_order->date_from != $now_date) 
        {
          return response(['message' => 'Checkin date is not today']);
        }
        
        if ($get_room->status_id == 1) 
        {
          return response(['message' => $get_room->name.' as been assigned']);
        }


        DB::beginTransaction();
          try 
          {
              Room::where('id', $request->input('room_id'))
                                ->update(['status_id'=> 1]);
              BookingOrderItem::where('id', $request->input('id'))
                                ->update([
                                  'status_id' => 5, 
                                  'room_id' => $request->input('room_id'), 
                                  'time_in' => date('Y-m-d H:i:s'),
                                ]);
              BookingOrder::where('id', $get_booking->booking_order_id)
                                ->update(['stage_id' => 2]);
             
           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

       return response(['message' => 'Room Checkin Successfully'], Response::HTTP_CREATED);
    }

    public function storeCheckout(Request $request)
    {
        $get_room = Room::find($request->input('room_id'));
        $get_booking = BookingOrderItem::find($request->input('id'));
        $now_date = date('Y-m-d');

        DB::beginTransaction();
          try 
          {
              Room::where('id', $request->input('room_id'))
                                ->update(['status_id'=> 2]);
              BookingOrderItem::where('id', $request->input('id'))
                                ->update([
                                  'status_id'    => 6, 
                                  'time_out'     => date('Y-m-d H:i:s'),
                                  'room_cost'    => $get_booking->cost,
                                  'room_gst'     => $get_booking->gst,
                                  'total_amount' => $get_booking->amount,

                                ]);
              BookingOrder::where('id', $get_booking->booking_order_id)
                                ->update(['stage_id' => 3]);

              $get_order = BookingOrderItem::find($get_booking->id);
              //credit the room sales account
              Ledger::create([
                              'tran_id' => $get_order->id, 
                              'transactype_id' => 3, 
                              'acct_one_id' => 1,
                              'acct_two_id' => $get_order->booking_order->user->account_id,
                              'amount' => $get_order->room_cost,
                              'enter_date' => $get_order->time_out,
                              'crdr_id' => 1,
                              'descp' => $get_order->booking_order->user->fullName().' '.' Room Sales of '
                                        .$get_order->room_cost,
                              'created_by'        => Auth::guard('admin')->user()->id,
                          ]);

              //credit the GST account
              Ledger::create([
                              'tran_id' => $get_order->id, 
                              'transactype_id' => 3, 
                              'acct_one_id' => 3,
                              'acct_two_id' => $get_order->booking_order->user->account_id,
                              'amount' => $get_order->room_gst,
                              'enter_date' => $get_order->time_out,
                              'crdr_id' => 1,
                              'descp' => 'Booking ID'.$get_order->booking_order_id.' '.' GST of '
                                        .$get_order->room_gst,
                              'created_by'        => Auth::guard('admin')->user()->id,
                          ]);

              //debit the user account
              Ledger::create([
                              'tran_id' => $get_order->id, 
                              'transactype_id' => 3, 
                              'acct_one_id' => $get_order->booking_order->user->account_id,
                              'acct_two_id' => 1,
                              'amount' => $get_order->total_amount,
                              'enter_date' => $get_order->time_out,
                              'crdr_id' => 2,
                              'descp' => $get_order->booking_order->user->fullName().' '.' Room Sales of '
                                        .$get_order->room_cost.' and GST charges of '
                                        .$get_order->room_gst,
                              'created_by'        => Auth::guard('admin')->user()->id,
                          ]);
             
           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

       return response(['message' => 'Room Checkout Successfully'], Response::HTTP_CREATED);
    }

    public function adminStore(BookingOrderRequest $request)
    {
        $room_group_id = $request->input('room_group_id');

        $room_group = RoomGroup::find($room_group_id)->toArray();

        $request->merge($room_group);

        $created_by = ['created_by' => Auth::guard('admin')->user()->id];
        $request->merge($created_by);
        
        $is_booked = ['is_booked' => 1];
        $request->merge($is_booked);

        $is_confirmed = ['status_id' => 4];
        $request->merge($is_confirmed);

        $roomsinfos = $request->input('rooms_info');

        DB::beginTransaction();
          try 
          {
              $get_user = User::find($request->input('user_id'));
              $booking_order = $get_user->booking_orders()
                               ->create($request->all())
                               ->booking_order_items()
                               ->createMany($roomsinfos);

              $get_order = BookingOrder::latest('created_at')->first();
             
           } 
          catch (Exception $e) 
          {
            DB::rollback();
            throw $e;
          }

        DB::commit();

      return response([
                        'orderid' => $get_order->id], Response::HTTP_CREATED);
    }

    

    

    
    public function confirm(BookingOrder $booking)
    {
      DB::beginTransaction();
        try 
        {
            $get_order = $booking;

            BookingOrder::where('id', $booking->id)
                                  ->update([
                                            'status_id' => 4, 
                                            'is_booked' => 1,
                                          ]); 
            BookingOrderItem::where('booking_order_id', $booking->id)
                                  ->update(['status_id' => 2]); 
           
         } 
        catch (Exception $e) 
        {
          DB::rollback();
          throw $e;
        }

      DB::commit();

      return response(['orderid' => $get_order->id], Response::HTTP_OK);
      
    }    
}

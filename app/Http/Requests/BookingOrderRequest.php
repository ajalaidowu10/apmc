<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'         => 'required|integer',
            'room_group_id'   => 'required|integer',
            'date_from'       => 'required|date',
            'date_to'         => 'required|date',
            'total_room'      => 'required|integer',
            'num_of_night'      => 'required|integer',
            'total_extra_bed' => 'required|integer',
            'rooms_info'      => 'required|array',

        ];
    }
}

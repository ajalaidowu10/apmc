<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class RoomGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
         return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|max:255',
            'descp'             => 'required|string',
            'room_price'        => 'required|numeric',
            'extra_bed_price'   => 'required|numeric',
            'status_id'         => 'required|integer',
        ];
    }
}

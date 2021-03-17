<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ItemExpRequest extends FormRequest
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
            'item_id'        => 'required|integer',
            'enterDate'      => 'required|date',
            'comm'           => 'required|numeric',
            'unit'           => 'required|numeric',
            'weight_pb'      => 'required|numeric',
            'p_hamali'       => 'required|numeric',
            'b_hamali'       => 'required|numeric',
            'p_levy'         => 'required|numeric',
            'b_levy'         => 'required|numeric',
            'apmc'           => 'required|numeric',
            'map_levy'       => 'required|numeric',
            'discount'       => 'required|numeric',
            'tolai'          => 'required|numeric',
            'status_id'      => 'required|integer',

        ];
    }
}

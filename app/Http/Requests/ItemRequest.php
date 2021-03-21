<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ItemRequest extends FormRequest
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
            'item_group_id' => 'required|integer',
            'name'          => 'required|string|max:255',
            'unit'          => 'required|numeric',
            'weight_pb'     => 'required|numeric',
            'status_id'     => 'required|integer',

        ];
    }
}

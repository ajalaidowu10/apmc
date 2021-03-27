<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class SalesOrderRequest extends FormRequest
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
            'acct_id'               => 'required|integer',
            'invoice_no'            => 'nullable|string',
            'enter_date'            => 'required|date',
            'other_charges'         => 'required|numeric',
            'levy'                  => 'required|numeric',
            'apmc'                  => 'required|numeric',
            'map_levy'              => 'required|numeric',
            'comm'                  => 'required|numeric',
            'tds'                   => 'required|numeric',
            'total_qty'             => 'required|numeric',
            'total_amount'          => 'required|numeric',
            'motor_no'              => 'required|string',
            'sales_order_items'   => 'required|array',

        ];
    }
}

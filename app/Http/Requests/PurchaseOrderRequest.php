<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PurchaseOrderRequest extends FormRequest
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
            'comm'                  => 'required|numeric',
            'other_charges'         => 'required|numeric',
            'apmc'                  => 'required|numeric',
            'total_qty'             => 'required|numeric',
            'total_amount'          => 'required|numeric',
            'motor_no'              => 'required|string',
            'purchase_order_items'   => 'required|array',

        ];
    }
}

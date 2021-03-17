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
            'cus_acct_id'           => 'required|integer',
            'total_qty'             => 'required|numeric',
            'total_amount'          => 'required|numeric',
            'descp'                 => 'required|string',
            'sales_order_items'     => 'required|array',

        ];
    }
}

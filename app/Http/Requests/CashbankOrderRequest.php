<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CashbankOrderRequest extends FormRequest
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
            'cashbank_type_id'      => 'required|integer',
            'payment_type_id'       => 'required|integer',
            'acct_one_id'           => 'required|integer',
            'total_amount'          => 'required|numeric',
            'enter_date'            => 'required|date',
            'cashbank_order_items'   => 'required|array',

        ];
    }
}

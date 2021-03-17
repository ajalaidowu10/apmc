<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class JournalOrderRequest extends FormRequest
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
            'total_cr_amount'          => 'required|numeric',
            'total_dr_amount'          => 'required|numeric',
            'enter_date'            => 'required|date',
            'journal_order_items'   => 'required|array',

        ];
    }
}

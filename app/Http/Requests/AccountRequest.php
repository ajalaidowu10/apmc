<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class AccountRequest extends FormRequest
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
            'account_type_id'     => 'required|integer',
            'crdr_id'             => 'required|integer',
            'groupcode_id'        => 'required|integer',
            'name'                => 'required|string|max:255|unique:accounts,name,'. $this->segment(3),
            'opening_bal'         => 'required|numeric',
            'status_id'           => 'required|integer',

        ];
    }
}

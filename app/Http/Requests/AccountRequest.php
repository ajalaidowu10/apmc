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
            'name'                => 'required|string|max:255|unique:accounts,name,'
                                      .$this->segment(3).',id,company_id,'.Auth::guard('admin')->user()->company_id,
            'opening_bal'         => 'required|numeric',
            'status_id'           => 'required|integer',
            'phone'               => 'string|nullable',
            'email'               => 'email|nullable',
            'address_one'         => 'string|nullable',
            'bank_name'           => 'string|nullable',
            'ifsc_code'           => 'string|nullable',
            'address_two'         => 'string|nullable',
            'area'               => 'string|nullable',
            'state'               => 'string|nullable',
            'zip'                 => 'string|nullable',
            'branch'              => 'string|nullable',
            'acct_no'             => 'string|nullable',
            'contact_person'      => 'string|nullable',
            'credit_days'         => 'numeric|nullable',
            'credit_limit'        => 'numeric|nullable',

        ];
    }
}

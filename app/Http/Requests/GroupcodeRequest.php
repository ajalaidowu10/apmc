<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class GroupcodeRequest extends FormRequest
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
            'parent_groupcode_id' => 'required|integer',
            'name'          => 'required|string|max:255|unique:groupcodes,name,'
                                      .$this->segment(3).',id,company_id,'.Auth::guard('admin')->user()->company_id,
            'descp'         => 'nullable|string',
            'status_id'     => 'required|integer',

        ];
    }
}

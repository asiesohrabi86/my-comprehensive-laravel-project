<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class CopanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' =>'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\ء-ي., ]+$/u',
            'amount_type' =>'required|numeric|in:0,1',
            // 'amount' field validation is depended on 'amount_type' field:
            'amount' => ['required', 'numeric', (request()->amount_type == 0) ? 'max:100' : ''],
            'type' =>'required|numeric|in:0,1',
            'discount_ceiling' =>'required|min:1|max:100000000000|numeric',
            'start_date' =>'required|numeric',
            'end_date' =>'required|numeric',
            'status' =>'required|numeric|in:0,1',
            'user_id' =>'required_if:type,==,1|min:1|max:100000000000|regex:/^[0-9]+$/u|exists:users,id',
        ];
    }

    public function attributes()
    {
        return [
            'amount' => 'میزان تخفیف'
        ];
    }

}

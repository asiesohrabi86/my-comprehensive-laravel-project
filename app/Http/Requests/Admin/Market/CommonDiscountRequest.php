<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class CommonDiscountRequest extends FormRequest
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
            'title' =>'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\ء-ي., ]+$/u',
            'percentage' =>'required|max:100|min:1|numeric',
            'discount_ceiling' =>'required|min:1|max:100000000000|numeric',
            'minimal_order_amount'  => 'required|min:1|max:100000000000|numeric',
            'status' =>'required|numeric|in:0,1',
            'start_date' =>'required|numeric',
            'end_date' =>'required|numeric',
        ];
    }
}

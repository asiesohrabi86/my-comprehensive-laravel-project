<?php

namespace App\Http\Requests\Admin\Market;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'name' =>'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\ء-ي., ]+$/u',
            'amount' =>'required|regex:/^[0-9]+$/u',
            'delivery_time' =>'required|integer',
            'delivery_time_unit' =>'required|regex:/^[ا-یa-zA-Z\ء-ي., ]+$/u',
        ];
    }
}

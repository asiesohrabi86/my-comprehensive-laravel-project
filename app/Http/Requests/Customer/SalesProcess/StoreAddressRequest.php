<?php

namespace App\Http\Requests\Customer\SalesProcess;

use App\Rules\PostalCode;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'province_id' => 'required|numeric|exists:provinces,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'address' => 'required|min:1|max:300',
            'postal_code' => ['required', new PostalCode()],
            'no' => 'required',
            'unit' => 'required',
            'reciever' => 'sometimes',
            'recepient_first_name' => 'required_with:reciever',
            'recepient_last_name' => 'required_with:reciever',
            'mobile' => 'required_with:reciever',
        ];
    }

    public function attributes() {
        return [
            'unit' => 'واحد',
            'mobile' => 'موبایل گیرنده',
        ];
    }

    
}

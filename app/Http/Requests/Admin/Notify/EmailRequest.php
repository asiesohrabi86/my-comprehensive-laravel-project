<?php

namespace App\Http\Requests\Admin\Notify;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
            'subject' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\ء-ي.,؟? ]+$/u',
            'published_at' => 'required|numeric',
            'status' =>'required|numeric|in:0,1',
            'body' => 'required|max:1000|min:5|regex: /^[ا-یa-zA-Z0-9\ء-ي.,><\/;\n\r& ]+$/u',
        ];
    }
}

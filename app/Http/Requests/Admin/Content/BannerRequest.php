<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        if ($this->isMethod('POst')) {
            return [
                'title' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\ء-ي., ]+$/u',
                'url' => 'required|max:500|min:5',
                'status' => 'required|numeric|in:0,1',
                'position' => 'required|numeric',
                'image' => 'required|image|mimes:png,jpg,jpeg,gif',
            ];
        }else{
            return [
                'title' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\ء-ي., ]+$/u',
                'url' => 'required|max:500|min:5',
                'status' => 'required|numeric|in:0,1',
                'position' => 'required|numeric',
                'image' => 'image|mimes:png,jpg,jpeg,gif',
            ];
        }
        
    }
}

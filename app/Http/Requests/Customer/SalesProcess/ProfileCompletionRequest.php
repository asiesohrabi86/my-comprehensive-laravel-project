<?php

namespace App\Http\Requests\Customer\SalesProcess;

use App\Rules\NationalCode;
use Illuminate\Foundation\Http\FormRequest;

class ProfileCompletionRequest extends FormRequest
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
            'first_name' => 'sometimes|required',
            'last_name' => 'sometimes|required',
            // میتواند ایمیل نالِبِل باشد ولی ما در سایتمان میخواهیم حتما پر شود
            // 'email' => 'sometimes|nullable|email|unique:users,email',
            'email' => 'sometimes|required|email|unique:users,email',
            // میتواند موبایل نالِبِل باشد ولی ما در سایتمان میخواهیم حتما پر شود
            // 'mobile' => 'sometimes|nullable|min:10|max:13|unique:users,mobile',
            'mobile' => 'sometimes|required|min:10|max:13|unique:users,mobile',
            'national_code' => ['sometimes', 'required', 'unique:users,national_code', new NationalCode()],
        ];
    }
}

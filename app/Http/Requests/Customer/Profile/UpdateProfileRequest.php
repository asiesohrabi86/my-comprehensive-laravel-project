<?php

namespace App\Http\Requests\Customer\Profile;

use App\Rules\NationalCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            // کاربر حق تعویض موبایل و ایمیل را ندارد، چون نیاز به فعالسازی دارد و باید اس ام اس فرستاده شود و...
            'national_code' => ['sometimes', 'required', Rule::unique('users')->ignore($this->user()->national_code,'national_code'), new NationalCode()],
        ];
    }
}

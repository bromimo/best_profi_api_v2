<?php

namespace App\Http\Requests;

use App\Assistants\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
//            'phone'      => ['required', 'regex:' . Constant::REGEX_PHONE, 'unique:subjects,phone'],
            'first_name' => ['required', 'string', 'max:64'],
            'last_name'  => ['sometimes', 'string', 'max:64']
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'The phone format must be like "+380xxxxxxxxx".',
            'phone.unique' => 'The phone already exist.',
        ];
    }
}

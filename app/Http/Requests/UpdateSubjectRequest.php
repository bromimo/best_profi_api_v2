<?php

namespace App\Http\Requests;

use App\Assistants\Constant;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateSubjectRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:64'],
            'last_name'  => ['sometimes', 'string', 'max:64'],
            'phones'         => ['required', 'array'],
            'phones.*.phone' => [
                'required',
                'phone',
                Rule::unique('phones')->where(function ($query) {
                    $query->whereNot('subject_id', $this->subject->id);
                })
            ]
        ];
    }
}

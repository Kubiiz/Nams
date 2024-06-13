<?php

namespace App\Http\Requests\Addresses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'counter' => ['required', 'in:number,number_photo,random,without'],
            'counter_from' => ['required', 'numeric', 'min:1', 'max:31'],
            'counter_to' => ['required', 'numeric', 'min:1', 'max:31'],
        ];
    }
}

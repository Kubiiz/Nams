<?php

namespace App\Http\Requests\Addresses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CreateAddressRule;

class CreateAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'company' => ['required', 'numeric', 'exists:companies,id', new CreateAddressRule($this->company)],
            'address' => ['required', 'min:3'],
        ];
    }
}

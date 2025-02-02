<?php

namespace App\Http\Requests\Addresses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CreateApartmentRule;

class CreateApartmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'address_id' => ['required', 'numeric', 'exists:addresses,id', new CreateApartmentRule($this->address_id)],
            'address' => ['required', 'min:3'],
        ];
    }
}

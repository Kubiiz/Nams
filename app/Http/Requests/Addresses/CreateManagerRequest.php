<?php

namespace App\Http\Requests\Addresses;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CreateManagerRule;

class CreateManagerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'     => ['required', 'email', 'exists:users,email', 'exists:companies,owner', new CreateManagerRule($this->address, $this->email)],
            'address'   => ['required', 'exists:addresses,id'],
        ];
    }
}

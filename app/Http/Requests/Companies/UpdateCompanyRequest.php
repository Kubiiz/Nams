<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $return = [
            'name' => ['required', 'min:3', Rule::unique('companies', 'name')->ignore($this->id)],
            'email' => ['required', 'email', 'string', 'lowercase'],
            'address' => ['required'],
            'reg_number' => ['required'],
            'bank_name' => ['required'],
            'bank_number' => ['required'],
        ];

        if (auth()->user()->isAdmin()) {
            $return = [
                'owner' => ['required', 'email', 'string', 'lowercase', 'exists:users,email'],
                'count' => ['required', 'numeric', 'min:1'],
            ];
        }

        return $return;
    }
}

<?php

namespace App\Rules;

use App\Models\Address;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateApartmentRule implements ValidationRule
{
    private $address;
    public function __construct($address)
    {
        $this->address = Address::find($address);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!auth()->user()->isAdmin() && (!auth()->user()->isOwner($this->address->company_id) || !auth()->user()->isManager($this->address->company_id))) {
            $fail(__('Something went wrong!'));
        }
    }
}

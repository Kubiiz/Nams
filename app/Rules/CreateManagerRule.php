<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Address;

class CreateManagerRule implements ValidationRule
{
    private $address, $email;
    public function __construct($address, $email)
    {
        $this->address = Address::find($address);
        $this->email = $email;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (in_array($this->email, explode('|', $this->address->managers))) {
            $fail(__('This manager already exists to this address.'));
        }

        if ($this->email == $this->address->company->owner) {
            $fail(__('Company owner cannot be manager of this address.'));
        }

        if (!auth()->user()->isAdmin() && $this->address->company->owner != auth()->user()->email) {
            $fail(__('":company" company does not belong to You!', ['company' => $this->address->company->name]));
        }
    }
}

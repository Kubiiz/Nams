<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Company;

class CreateAddressRule implements ValidationRule
{
    private $company;
    public function __construct($company)
    {
        $this->company = Company::find($company);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->company->addresses->count() >= $this->company->count) {
            $fail(__(':company has reached the limit of :count addresses', ['company' => $this->company->name, 'count' => $this->company->count]));
        }

        if (!auth()->user()->isAdmin() && $this->company->owner != auth()->user()->email) {
            $fail(__('This company does not belong to You!'));
        }
    }
}

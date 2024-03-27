<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'owner', 'address', 'invoice_number', 'reg_number', 'bank_name', 'bank_number', 'active',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}

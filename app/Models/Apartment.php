<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_id', 'appartment', 'address', 'owner',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}

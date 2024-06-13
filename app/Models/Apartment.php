<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address_id', 'appartment', 'address', 'owner',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Apartment extends Model
{
    use HasFactory, Sortable, SoftDeletes;

    protected $fillable = [
        'address_id', 'apartment', 'address', 'owner',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}

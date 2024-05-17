<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'company_id', 'address', 'managers',
    ];

    public $sortable = [
        'id',
        'company_id',
        'address',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function apartment()
    {
        return $this->hasMany(Apartment::class);
    }
}

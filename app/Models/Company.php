<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, Sortable, SoftDeletes;

    protected $fillable = [
        'name', 'owner', 'email', 'address', 'reg_number', 'bank_name', 'bank_number', 'count',
    ];

    public $sortable = [
        'id',
        'name',
        'owner',
        'email',
        'address',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}

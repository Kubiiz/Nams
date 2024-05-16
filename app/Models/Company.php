<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Company extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'name', 'owner', 'email', 'address', 'invoice_number', 'reg_number', 'bank_name', 'bank_number', 'active',
    ];

    public $sortable = [
        'id',
        'name',
        'owner',
        'email',
        'address',
        'active',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function hasPermission($permission)
    {
        return Permission::check('company', $this->id, $permission, 0);
    }
}

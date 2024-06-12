<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Company;
use App\Models\Address;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, Sortable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'phone',
    ];

    public $sortable = [
        'id',
        'name',
        'surname',
        'email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function apartment()
    {
        return $this->hasMany(Apartment::class, 'owner');
    }

    public function isAdmin()
    {
        return $this->where('id', $this->id)->where('access', 1)->exists();
    }

    public function isOwner($id = null)
    {
        $query = Company::where('owner', $this->email);

        if ($id) {
            $query = $query->where('id', $id);
        }

        $query = $query->exists();

        if (!$query && !$this->isAdmin()) {
            return false;
        }

        return true;
    }

    public function isManager($id = null)
    {
        $query = Address::where('managers', 'LIKE', "%$this->email%");

        if ($id) {
            $query = $query->where('company_id', $id);
        }

        $query = $query->exists();

        if (!$query && !$this->isOwner()) {
            return false;
        }

        return true;
    }

    public function accessToPanel()
    {
        if ($this->isAdmin() || $this->isOwner() || $this->isManager()) {
            return true;
        }

        return false;
    }
}

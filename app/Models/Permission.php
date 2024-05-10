<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'id', 'permission',
    ];

    public $timestamps = false;

    // List of permissions and titles
    public static function list()
    {
        $list = [
            'panel'         => 'Access to control panel',
            'users'         => 'Can manage users',
            'users_perm'    => 'Can edit user permissions',
            'companies'     => 'Can manage companies',
            'addresses'     => 'Can manage addresses',
            'apartments'    => 'Can manage apartments',
            'invoices'      => 'Can manage invoices',
            'notices'       => 'Can manage notices',
            'polls'         => 'Can manage polls',
            'settings'      => 'Can manage settings',
            'statistics'    => 'Can see webpage statistics',
        ];

        return $list;
    }

    //Check if user or company has permission to do something
    public static function check($type, $id, $permission, $user = null)
    {
        $query = Permission::where([
                                'type' => $type,
                                'id'=> $id,
                                'permission' => $permission])
                            ->orWhere(function ($query) use($user) {
                                $query->where([
                                    'type' => 'user',
                                    'id' => $user ?? Auth::user()->id,
                                    'permission' => 'admin'
                                ]);
                            })
                            ->exists();

        if (!Auth::user()->hasVerifiedEmail() || !$query) {
            return false;
        }

        return $query;
    }
}

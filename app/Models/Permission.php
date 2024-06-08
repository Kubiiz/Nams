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
            'Owner'         => 'Company owner - can manage own companies - addresses, apartments, counters, invoices, notices, polls',
            'Manager'       => 'Company manager - can manage companies specific addresses',
        ];

        return $list;
    }

    // Check if user has permission to do something
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
                                    'permission' => 'Admin'
                                ]);
                            })
                            ->exists();

        if (!Auth::user()->hasVerifiedEmail() || !$query) {
            return false;
        }

        return $query;
    }

    // Check if user has access to controlpanel
    public static function panel()
    {
        $query = Permission::where([
                                'type' => 'user',
                                'id'=> Auth::user()->id
                            ])
                            ->whereIn('permission', ['Owner', 'Manager', 'Admin'])
                            ->exists();

        if (!Auth::user()->hasVerifiedEmail() || !$query) {
            return false;
        }

        return $query;
    }

    // Create permission
    public static function create($type, $id, array $permissions)
    {
        if (empty($permissions)) {
            return false;
        }

        foreach($permissions as $permission) {
            if (isset(Permission::list($type)[$permission])) {
                Permission::where('type', $type)
                        ->where('id', $id)
                        ->whereNot('permission', 'Admin')
                        ->firstOrCreate([
                            'type'       => $type,
                            'id'         => $id,
                            'permission' => $permission,
                        ]);
            }
        }
    }

    // Remove permission
    public static function remove($type, $id, array $permissions)
    {
        if (empty($permissions)) {
            return false;
        }

        foreach ($permissions as $permission) {
            Permission::where([
                    'type' => $type,
                    'id' => $id,
                    'permission' => $permission,
                ])
                ->whereNot('permission', 'Admin')
                ->delete();
        }
    }
}

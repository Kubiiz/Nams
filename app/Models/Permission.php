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

    // Check if user or company has permission to do something
    public static function check($type, $id, $permission)
    {
        $query = Permission::where([
                                'type' => $type,
                                'id'=> $id,
                                'permission' => $permission])
                            ->orWhere(function ($query) {
                                $query->where([
                                    'type' => 'user',
                                    'id' => Auth::user()->id,
                                    'permission' => 'admin'
                                ]);
                            })
                            ->exists();

        return $query;
    }
}

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

    /**Check if user or company has permission to do something
     *
     * User permissions:
     * admin        - can do anything
     * panel        - access to controlpanel
     * users        - can manage users
     * users_perm   - can edit users permissions
     * companies    - can manage companies
     * addresses    - can manage addresses
     * apartments   - can manage apartments
     * invoices     - can manage invoices
     * notices      - can manage notices
     * polls        - can manage polls
     * settings     - can manage settings
     * statistics   - can see webpage statistics
     */
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

        if (!Auth::user()->hasVerifiedEmail() || !$query) {
            return false;
        }

        return $query;
    }
}

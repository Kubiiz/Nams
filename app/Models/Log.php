<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Log extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['link', 'note', 'ip_address', 'result'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

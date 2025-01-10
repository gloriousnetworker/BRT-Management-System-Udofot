<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BRT extends Model
{
    use HasFactory;

    protected $table = 'brts';
    protected $fillable = ['user_id', 'brt_code', 'reserved_amount', 'status'];

    /**
     * Relationship: A BRT belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

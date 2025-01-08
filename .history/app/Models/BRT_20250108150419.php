<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BRT extends Model
{
    protected $table = 'b_r_t_s'; 
    protected $fillable = ['user_id', 'brt_code', 'reserved_amount', 'status']; // Add fillable fields

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BRT extends Model
{
    // Defining the relationship back to the User model
    public function user()
    {
        return $this->belongsTo(User::class); // Each BRT belongs to a user
    }
}

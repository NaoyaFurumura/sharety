<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    public function user(){
        return belongsTo(User::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'name', 'description', 'price_per_day','state','user_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos(){
        return $this->hasMany('App\ItemPhoto');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function borrows(){
        return $this->hasMany(Borrow::class);
    }

    public function favorites(){
        return $this->belongsToMany(User::class, 'favorites', 'post_id', 'user_id')->withTimestamps();
    }



    

}

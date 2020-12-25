<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPhoto extends Model
{

    protected $fillable=['item_img','post_id'];

    public function posts(){
        return $this->belongsTo(Post::class);
    }

    
    
}

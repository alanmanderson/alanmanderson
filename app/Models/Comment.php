<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    public function author(){
        return $this->belongsTo('App\Models\User' , 'user_id');
    }

    public function post(){
        return $this->belongsTo('App\Models\Post');
    }
}

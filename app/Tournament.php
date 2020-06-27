<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{

    //the users that belong to a tournament
    public function users() {
        return $this->belongsToMany('App\User', 'user_tournament');
    }
}

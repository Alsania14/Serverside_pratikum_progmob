<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailEvent extends Model
{
    protected $table = 'detail_events';

    public function Event(){
        return $this->belongsTo('App\Event', 'event_id', 'id');
    }

    public function User(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}

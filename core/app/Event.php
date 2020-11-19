<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function EventFirstImage(){
        return $this->hasMany('App\Event_image','event_id')->first()['image_name'];
    }

    public function countMember(){
        return $this->hasMany('App\DetailEvent','event_id')->count();
    }

    public function eventCreator(){
        return $this->belongsTo('App\User','user_id')->first();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    public function appointments() {
        return $this->hasMany('App\Appointment');
    }

    public function availabilities() {
        return $this->hasMany('App\Availability');
    }
}

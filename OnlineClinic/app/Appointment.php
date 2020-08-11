<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * @var mixed
     */
    private $provider_id;
    /**
     * @var mixed
     */
    private $patient_id;
    /**
     * @var mixed
     */
    private $start_datetime;
    /**
     * @var mixed
     */
    private $end_datetime;

    public function availabilities() {
        return $this->hasMany('App\Availability');
    }
}

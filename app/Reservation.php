<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Reservation
 * @package App
 */

class Reservation extends Model
{
    protected $guarded = array();
    //disable timestamps
    public $timestamps = false;
}
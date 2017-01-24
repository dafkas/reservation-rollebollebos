<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
  public function reservation() {
    return $this->belongsTo('reservation');
  }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class holidays extends Model
{
  public function holiday_type()
  {
      return $this->belongsTo('App\holiday_types');
  }
}

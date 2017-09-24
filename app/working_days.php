<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class working_days extends Model
{
  public function salary()
  {
      return $this->belongsTo('App\salarys');
  }

  public function attendences()
  {
      return $this->hasMany('App\attendences','working_day_id');
  }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class salarys extends Model
{
  public function working_days()
  {
      return $this->hasMany('App\working_days');
  }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class slips extends Model
{
  public function employee()
  {
      return $this->belongsTo('App\Employees');
  }

  public function salary()
  {
      return $this->belongsTo('App\salarys');
  }

  public function slip_features()
  {
      return $this->hasMany('App\slip_features');
  }
}

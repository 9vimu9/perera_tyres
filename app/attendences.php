<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attendences extends Model
{
  // protected $dates = ['created_at', 'updated_at', 'time'];

  public function working_day()
  {
      return $this->belongsTo('App\working_days');
  }

  public function employee()
  {
      return $this->belongsTo('App\Employees');
  }
}

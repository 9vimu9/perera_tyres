<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class leaves extends Model
{
  public function leave_type()
  {
      return $this->belongsTo('App\leave_types');
  }

  public function employee()
  {
      return $this->belongsTo('App\Employees');
  }
}

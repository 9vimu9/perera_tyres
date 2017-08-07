<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
  public function cat()
  {
      return $this->belongsTo('App\cats');
  }

  public function branch()
  {
      return $this->belongsTo('App\branchs');
  }
}

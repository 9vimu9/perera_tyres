<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee__designations extends Model
{
  public function designation()
  {
      return $this->belongsTo('App\designations');
  }
}

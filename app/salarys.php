<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class salarys extends Model
{
  public function budget_allowance()
  {
      return $this->belongsTo('App\budget_allowances');
  }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cats extends Model
{
  public function cat_working_day()
  {
      return $this->haveOne('App\cat_working_days');
  }
}

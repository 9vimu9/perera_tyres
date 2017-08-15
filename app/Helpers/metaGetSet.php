<?php

function MetaGet($name)
{
  return App\meta::where('name' , $name)->first()->value;


}

function MetaSet($name,$value)
{
  App\meta::where('name', $name)->update(['value' => $value]);
}



 ?>

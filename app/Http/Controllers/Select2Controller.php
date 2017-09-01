<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Select2Controller extends Controller
{
  public function GetSuggestionsForSelect2(Request $request)
  {
      $id = trim($request->id);
      $term = trim($request->q);
      $table = trim($request->t);
      $column = trim($request->c);

      if (empty($term)) {
          return \Response::json([]);
      }

      $results = array();

      $results = $this->GetData($id,$column,$table,$term);
      return response()->json($results);
  }

  public function GetData($id=0,$column,$table,$term)
  {
    $data=NULL;
    switch ($id) {

      case 0://general//
        $data= DB::table($table)->where($column, '=', $term);
        break;

      case 1:
        break;

      default:
        # code...
        break;
    }

    if($data){
      return $data->orWhere($column, 'LIKE', '%' . $term . '%')->get(['id', $column.' as value']);
    }
  }


}

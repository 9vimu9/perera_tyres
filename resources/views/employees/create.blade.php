@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1">
      <h3><p class="text-center">CREATE EMPLOYEE</p></h3>
      <form class="form-horizontal" role="form" method="post" action="/employees">
        {{ csrf_field() }}
        @include('employees.form')
      </form>
    </div>
  </div>
</div>


@endsection

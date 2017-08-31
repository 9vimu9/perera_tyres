@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <h3><p class="text-center">@yield('title')</p></h3>
        @yield('panels')
    </div>
  </div>
</div>









@endsection

@section('script')

  @yield('script')

@endsection

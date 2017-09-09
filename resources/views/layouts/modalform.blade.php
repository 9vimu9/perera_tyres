@extends('layouts.app')

@section('content')

<div class="container">


      <h3><p class="text-center">@yield('title')</p></h3>

        @yield('optional_space')

      <div class="panel panel-info">
        <div class="panel-heading">
        <button type="button" class="btn btn-success create" data-toggle="modal" data-target="#modalform_modal" >
          @yield('create_new')
        </button>
        @yield('panel_heding_right_side_button')
        </div>
        <div class="panel-body" >
        @yield('table')
        </div>
      </div>


</div>

<form  id='form' action="" method="post">
  {{ csrf_field() }}

<input type="hidden" name="_method" id="method">

  <div class="modal fade" id="modalform_modal"  role="dialog"  aria-hidden="true">
    <div class="modal-dialog" style="width:90%;">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modal_title"></h4>
        </div>

        <div class="modal-body">

          @yield('modal_form')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">cancel</button>
          <input id="submit" type="submit" class="btn btn-primary save">
          {{-- <input id="submit" type="" class="btn btn-primary save"> --}}

        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@section('script')

  @if (count($errors->all())>0)
    <script>
    window.onload = function(){
      $('.create').click();
    }
    </script>
  @endif
  <script>
  function Route_call(route,title,method,submit_btn_name) {
    $('.create').click(function () {
      $("#method").val(method);
      $('#form').attr('action', "/"+route);
      $('#modal_title').html(title);
      $('#submit').val(submit_btn_name);
    });

  }

    function create_update_toggle(route,title) {
      Route_call(route,'add new '+title,'POST','create');

      $('.edit').click(function () {
        $("#method").val('PUT');
        $('#form').attr('action', "/"+route+"/"+$(this).attr('id'));
        $('#modal_title').html('edit '+title);
        $('#submit').val('update');
      });
    }
  </script>
  @yield('form_script')
@endsection

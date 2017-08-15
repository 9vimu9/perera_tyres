@extends('layouts.app')

@section('content')

<div class="container">


      <h3><p class="text-center">@yield('title')</p></h3>

        @yield('optional_space')

      <div class="panel panel-info">
        <div class="panel-heading">
        <button type="button" class="btn btn-success create" data-toggle="modal" data-target="#salarys_index_modal" >
          @yield('create_new')
        </button>
        </div>
        <div class="panel-body">
        @yield('table')
        </div>
      </div>


</div>

<form  id='form' action="" method="post">
  {{ csrf_field() }}

<input type="hidden" name="_method" id="method">
  <div class="modal fade" id="salarys_index_modal"  role="dialog"  aria-hidden="true">
    <div class="modal-large ">
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
        </div>
      </div>
    </div>
  </div>
</form>




@endsection

@section('script')
  <script>
    function create_update_toggle(route,title) {
      $('.create').click(function () {
        $("#method").val('POST');
        $('#form').attr('action', "/"+route);
        $('#modal_title').html('add new '+title);
        $('#submit').val('create');
      });

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

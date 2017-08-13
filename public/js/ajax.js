var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

function AjaxPOST(data,url,type) {
    //_token: CSRF_TOKEN,
    data._token= CSRF_TOKEN;
  $.ajax({
    async: false,
    url: url,
    type: type,
    data: data,
    dataType: 'JSON',
    success: function (data) {
        console.log(data);
    },

    error: function(data){
      var errors = data.responseJSON;
       console.log(errors);
       // Render the errors with js ...
     }
  });
}



function AjaxGetData(path,method,queryData) {


    var data={path:path,query:queryData};

    if(method=='post'){
        data._token= CSRF_TOKEN;
    }

  return $.ajax({
    async: false,
    url: '/ajax_call',
    type: method,
    data: data,
    dataType: 'JSON',
    error: function(data){
      var errors = data.responseJSON;
       console.log(errors);
       // Render the errors with js ...
     }
  });

}

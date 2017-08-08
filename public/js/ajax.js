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


AjaxGetData(2,'post',null).success(function (data) {

  $('#calendar').fullCalendar({
  			header: {
  				left: 'prev,next today',
  				center: 'title',
  				right: 'month'
  			},
        dayClick: function (date, jsEvent, view) {
          $(".fc-state-highlight").removeClass("fc-state-highlight");
          $(this).addClass("fc-state-highlight");

          var selected_date=moment(date._d).format('YYYY/MM/DD');
          $('#selected_date').val(selected_date);


           //console.log('Clicked on: ' + date.getDate()+"/"+date.getMonth()+"/"+date.getFullYear());
        },
  			defaultDate: moment().format('YYYY/MM/DD'),
  			navLinks: true, // can click day/week names to navigate views
  			editable: true,
  			eventLimit: true, // allow "more" link when too many events
  			events: data
  		});


});

var Admin = {

  toggleLoginRecovery: function(){
    var is_login_visible = $('#modal-login').is(':visible');
    (is_login_visible ? $('#modal-login') : $('#modal-recovery')).slideUp(300, function(){
      (is_login_visible ? $('#modal-recovery') : $('#modal-login')).slideDown(300, function(){
        $(this).find('input:text:first').focus();
      });
    });
  }

};

$(function(){

  $('.toggle-login-recovery').click(function(e){
    Admin.toggleLoginRecovery();
    e.preventDefault();
  });

  var defaults = {
    calendarWeeks: true,
    showClear: true,
    showClose: true,
    allowInputToggle: true,
    useCurrent: false,
    ignoreReadonly: true,
    //minDate: new Date(),
    toolbarPlacement: 'top',
    locale: 'vi',
    icons: {
      time: 'fa fa-clock-o',
      date: 'fa fa-calendar',
      up: 'fa fa-angle-up',
      down: 'fa fa-angle-down',
      previous: 'fa fa-angle-left',
      next: 'fa fa-angle-right',
      today: 'fa fa-dot-circle-o',
      clear: 'fa fa-trash',
      close: 'fa fa-times'
    }
  };

  var optionsDatetime = $.extend({}, defaults, {format:'DD-MM-YYYY HH:mm'});
  var optionsDate = $.extend({}, defaults, {format:'DD-MM-YYYY'});
  var optionsTime = $.extend({}, defaults, {format:'HH:mm'});

  $('.datepicker').datetimepicker(optionsDate);
  $('.timepicker').datetimepicker(optionsTime);
  $('.datetimepicker').datetimepicker(optionsDatetime);


  //ajax view tour
  $(".view-tour").click(function(){
    var id = this.getAttribute('data-id');
    var title = this.getAttribute('data-title');
    $.ajax({
      url: base_url+'/ajax-viewTour',
      type: 'POST',
      dataType: "html",
      data: {id: id,},
      beforeSend:function(d){
        $('.modal-body').html("<center><strong style='color:red'>Please Wait...<br><img height='25' width='120' src='"+ base_url +"/assets/img/giphy.gif' /></strong></center>");
      },
      error: function() {
        alert('Something is xxx wrong');
      },
      success: function(data) {
        $("#myModalLabel").html(title);
        $(".modal-body").html(data);
      }
    });
  });
//tooltip test
   $('#right').tooltip();
   $('.tooltip-showname').tooltip();


//test ajax
  $(".testx").click(function(){
    // var data = this.getAttribute('data-id');
    // alert(data);
    var stock = $("input[name='stock']").val();
    var description = $("textarea[name='description']").val();
    $.ajax({
      url: base_url+'/ajax-requestPost',
      type: 'POST',
      dataType: "html",
      data: {stock: stock, description: description},
      beforeSend:function(d){
        $('#div_result').html("<center><strong style='color:red'>Please Wait...<br><img height='25' width='120' src='"+ base_url +"/assets/img/giphy.gif' /></strong></center>");

      },
      error: function() {
        alert('Something is wrong');
      },
      success: function(data) {
        $("tbody").append("<tr><td>"+stock+"</td><td>"+description+"</td></tr>");
        $("#div_result").html(data);
      },

    });
  });


    var extra = 0;
    var $input = $( "#convert_number" );

    $input.on( "keyup", function( event ) {

      // When user select text in the document, also abort.
      var selection = window.getSelection().toString();
      if ( selection !== '' ) {
        return;
      }

      // When the arrow keys are pressed, abort.
      if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
        if(event.keyCode == 38){extra = 1000;}
        else if(event.keyCode == 40){extra = -1000;}
        else{return;}

      }

      var $this = $( this );
      // Get the value.
      var input = $this.val();
      var input = input.replace(/[\D\s\._\-]+/g, "");
      input = input ? parseInt( input, 10 ) : 0;
      input += extra;
      extra = 0;
      $this.val( function() {
        return ( input === 0 ) ? "" : input.toLocaleString( "de-DE" );
      } );
    } );


});



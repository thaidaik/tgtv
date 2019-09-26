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

});

(function($) {
  
  "use strict";  
  $( document ).ready(function() {
    // Session Popup
    $('.sessionmodal').addClass("active");
    setTimeout(function() {
        $('.sessionmodal').removeClass("active");
    }, 4000);
    
    // To Choose Custom And Imdb Detail
    $('#custom_dtl').hide();
    $(".imdb_btn").on('click', function(){
      $('#custom_dtl').hide();
    });
    $(".custom_btn").on('click', function(){
      $('#custom_dtl').show();
    });
  });

  //Select2
  $('.select2').select2({
    tags: true,
    tokenSeparators: [',']
  });
  
  //Date picker
  $('.date-pick').datepicker({
    autoclose: true,
  });

  //Timepicker
  $('.timepicker').timepicker({
    showInputs: false,
  });

  $('.currency-icon-picker').iconpicker({
    title: 'Currency Symbols',
    icons: ['fa fa-dollar', 'fa fa-euro', 'fa fa-gbp', 'fa fa-ils', 'fa fa-inr', 'fa fa-krw', 'fa fa-money', 'fa fa-rouble', 'fa fa-try'],
    selectedCustomClass: 'label label-primary',
    mustAccept: false,
    placement: 'topRight',
    showFooter: false,
    hideOnSelect: true,
  });

  $(".bootswitch").bootstrapSwitch();
  $('.dropdown-toggle').dropdown();
  $('[data-toggle="tooltip"]').tooltip({animation: true, delay: {show: 300, hide: 300}});   

  $('.input-file').each(function() {
      var $input = $(this),
          $label = $input.next('.btn'),
          labelVal = $label.html();
      
       $input.on('change', function(element) {
          var fileName = '';
          if (element.target.value) fileName = element.target.value.split('\\').pop();
          fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);
       });
    });
})(jQuery);

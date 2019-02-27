$(document).ready(function() {
  $("#spinner").on("input", function(evt) {
      var self = $(this);
     self.val(self.val().replace(/[^0-9\.]/g, ''));
     if(self.val()<1) self.val(1);
     else if(self.val()>5000) self.val(5000);
     if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
     {
       evt.preventDefault();
     }
   });

$( function() {
    $( ".widget input[type=submit], .widget a, .widget button" ).button();
    $( "#salutation" ).selectmenu();

    $( "#spinner" ).spinner({
          spin: function( event, ui ) {
            if ( ui.value > 5000 ) {
              $( this ).spinner( "value", 5000 );
              return false;
            } else if ( ui.value < 1 ) {
              $( this ).spinner( "value", 1 );
              return false;
            }
          }});

  } );
  $( "#dialog" ).dialog({
    modal: true,
  	autoOpen: false,
  	width: 400,
    buttons: {
      Ok: function() {
        $(location).attr('href',window.location.pathname);
        $( this ).dialog( "close" );
      }
    }
  });

});

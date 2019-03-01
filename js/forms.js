$(document).ready(function() {
  $("a.ajax").click(function() {
      $("#modal-ajax").attr("title",$(this).html());
      $("#modal-ajax").dialog( "option", "title", $(this).html() );
      $.ajax({
        url: $(this).attr("href"),
        type: "POST",
        dataType: "html"
      }).done(function(msg) {
        $( "#modal-ajax" ).html(msg);
        $( "#salutation, #salutation2" ).selectmenu();
        $( "#datepicker" ).datepicker();
        $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        $("#datepicker").val($.datepicker.formatDate('yy-mm-dd', new Date()));
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
        $( "#modal-ajax" ).dialog( "open" );
      });
      return false;
  });

  $("#modal-ajax").dialog({
    resizable: false,
    draggable: false,
    modal: true,
    autoOpen: false,
    width: 1000,
    buttons: {
      Ok: function() {
        $.ajax({
          url: $(this).find("form").attr("actions"),
          type: "POST",
          data: {data : $(this).find("form").serialize()},
          dataType: "html"
        }).done(function(msg) {
          $( "#modal-alert" ).html(msg);
          $( "#modal-alert" ).dialog( "open" );
        });
        $( this ).dialog( "close" );
      }, Calcel: function() { $( this ).dialog( "close" ); }
    }
  });

  $("#modal-alert").dialog({
    resizable: false,
    draggable: false,
    modal: true,
    autoOpen: false,
    width: 350,
    buttons: {
      Ok: function() {$(location).attr('href',window.location); $( this ).dialog( "close" );}
    }
  });
});

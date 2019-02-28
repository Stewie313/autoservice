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
        $( "#modal-ajax" ).dialog( "open" );
      });
      return false;
  });

  $("#modal-ajax").dialog({
    resizable: false,
    draggable: false,
    modal: true,
    autoOpen: false,
    width: 800,
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
      Ok: function() {$(location).attr('href',window.location.pathname); $( this ).dialog( "close" );}
    }
  });
});

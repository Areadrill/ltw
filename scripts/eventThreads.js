$(document).ready(function(){
  $("#createThreadButton").click(function(){
    $("#threadCreation").show(500);
  });

  $("#threadCreation form").submit(function(){
    event.preventDefault();

    $.post(
      "database/action_createThread.php",
      {threadTitle: $("input[name=threadTitle]").val(),
        threadText: $("textarea[name=threadText]").val(),
      eventId: $("#eventIdHidden").val()},
      function(data){
        var domElements = $.parseHTML(data);
        $("section#threads").append(domElements);
        $("#threadCreation").hide(400);
      }).fail(function(){
        alert("Thread by that name already exists");
      });
  });
});

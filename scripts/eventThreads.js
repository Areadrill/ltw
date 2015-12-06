$(document).ready(function(){
  $("#createThreadButton").click(function(){
    $("#albumCreation").hide();
    $("#threadCreation").show(500);

  });

  $("#threadCreation form").submit(function(){
    event.preventDefault();

    $.post(
      "database/action_createThread.php",
      {threadTitle: $("input[name=threadTitle]").val(),
        threadText: $("textarea[name=threadText]").val(),
      eventId: $("#eventIdHidden").val(),
      csrf: $("#csrf").val()},
      function(data){
        var domElements = $.parseHTML(data);
        $("section#threads").append(domElements);
        $("#threadCreation").hide(400);
      }).fail(function(){
        alert("Thread by that name already exists");
      });
  });

  $("#createAlbumButton").click(function(){
    $("#threadCreation").hide();
    $("#albumCreation").show(500);
  });

  $("#albumCreationForm").submit(function(){
    event.preventDefault();
    $.post(
      "database/action_createAlbum.php",
      {albumName: $("input[name=albumName]").val(), eventId:$("#eventIdField").val(), csrf: $("#csrf").val()},
      function(data){
        console.log(data);
        location.reload(true);
      }
    ).fail(function(){
      alert("Album by that name could not be created.");
    });
  });

});

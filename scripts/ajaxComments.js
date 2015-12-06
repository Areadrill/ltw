function setup(){
  $("#createComment").submit(ajaxComment);
}

function checkValidText(){
  var text = $("#commentText").val();
  $(".textValidInfo").remove();
  if(text != null && text.length <= 1000){
    return true;
  }
  $("#commentText").after("<span class=\"textValidInfo\">Invalid comment content</span>");
  return false;
}

function ajaxComment(){
  event.preventDefault();
  var formData = new FormData($(this)[0]);

  if(checkValidText()){
    $.ajax({
      url: "database/action_addComment.php",
      type: 'POST',
      data: formData,
      async: true,
      success: function(response){
        console.log(response);

        var comment = $.parseHTML(response);
        $("#writeComment").last().before(comment);
      },
      cache: false,
      contentType: false,
      processData: false
    });
    return true;
  }
  console.log("ola");
  return false;
}

$(document).ready(setup);

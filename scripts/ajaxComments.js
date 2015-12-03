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
  if(checkValidText()){
    $.ajax({
      url: "database/action_addComment.php",
      type: 'POST',
      data: {comment: $("#commentText").val(), threadId: $("#tid").val()},
      async: false,
      success: function(response){
        console.log(response);
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

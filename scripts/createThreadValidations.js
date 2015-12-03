function setup(){
  $("#createThread").submit(validate);

}

function checkValidName(){
  var name = $("#threadTitle").val();
  $(".titleValidInfo").remove();
  if(name != "" && name.length <= 50){
    return true;
  }
  else{
    $("#threadTitle").after("<span class=\"titleValidInfo\">Thread title is invalid</span>");
    return false;
  }
}

function checkValidText(){
  var text = $("#threadText").val();
  $(".textValidInfo").remove();
  if(text != "" && text.length <= 1000){
    return true;
  }
  else{
    $("#threadText").after("<span class=\"textValidInfo\">Text is invalid</span>");
    return false;
  }
}

function validate(){
  if(!checkValidName() || !checkValidText()){
    return false;
  }
}

$(document).ready(setup);

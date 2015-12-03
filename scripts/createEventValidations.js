function setup(){
  $("#createEvent").submit(validate);
}

function checkValidName(){
  var name = $("#eventName").val();
  $(".nameValidInfo").remove();
  if(name != "" && name.length <= 25){
    return true;
  }
  else{
    $("#eventName").after("<span class=\"nameValidInfo\">Event name is invalid</span>");
    return false;
  }
}

function checkDateNotNull(){
  console.log("date lol");
  var date = $("#eventDate").val();
  console.log(date);
  $(".dateValidInfo").remove();
  if(date == ''){
    $("#eventDate").after("<span class=\"dateValidInfo\">Need to specify a date</span>");
    return false;
  }
  return true;
}

function checkValidDesc(){
  var desc = $("#eventDescription").val();
  $(".descValidInfo").remove();
  if(desc != "" && desc.length <= 1000){
    return true;
  }
  else{
    $("#eventDescription").after("<span class=\"nameValidInfo\">Event description is invalid</span>");
    return false;
  }
}

function checkImageSelected(){
  var file = $("#eventImage").val();
  var extension = file.substring(file.lastIndexOf('.')+1).toLowerCase();
  console.log(extension);
  $(".imageValidInfo").remove();
  if(file == ''){
    $("#eventImage").after("<span class=\"imageValidInfo\">Need to select an image.</span>");
    return false;
  }
  else {
    switch (extension){
      case "jpg":
      case "png":
        return true;
      default:
        $("#eventImage").after("<span class=\"imageValidInfo\">Not an accepted extension. Accepted extensions are jpg and png.</span>");
        return false;
    }
  }
}

function validate(){
  if(!checkValidName() || !checkDateNotNull() || !checkValidDesc() || !checkImageSelected()){
    return false;
  }
}

$(document).ready(setup);

function setup(){
    $("#password").change(checkMatchingPasswords);
    $("#repass").change(checkMatchingPasswords);
}

function checkMatchingPasswords(){
  var pass1 = $("#password").val();
  var pass2 = $("#repass").val();
  console.log("pass1 " + pass1);
  console.log("pass2 " + pass2);
  if(pass1 === pass2){
    $("#password").after("Passwords match");
    return true;
  }
  else{
    $("#password").after("Passwords don't match");
    return false;
  }
}

$(document).ready(setup);

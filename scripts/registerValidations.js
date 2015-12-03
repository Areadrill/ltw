function setup(){
    $("#password").change(checkMatchingPasswords);
    $("#repass").change(checkMatchingPasswords);
    $("#mail").change(checkValidEmail);
    $("#register").submit(validate);

}

function checkMatchingPasswords(){
  var pass1 = $("#password").val();
  var pass2 = $("#repass").val();
  $(".passMatchInfo").remove();
  if(pass1 === ""){
    $("#password").after("<span class=\"passMatchInfo\">Password can't be empty</span>");
    return false;
  }

  if(pass1 === pass2){
    $("#password").after("<span class=\"passMatchInfo\">Passwords match</span>");
    return true;
  }
  else{
    $("#password").after("<span class=\"passMatchInfo\">Passwords don't match</span>");
    return false;
  }
}

function checkValidEmail(){
  var emailRE = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
  var mail = $("#mail").val();
  $(".emailValidInfo").remove();
  if(mail === ""){
    $("#mail").after("<span class=\"emailValidInfo\">E-mail can't be empty</span>");
    return false;
  }

  if(!emailRE.test(mail)){
    $("#mail").after("<span class=\"emailValidInfo\">Not a valid e-mail</span>");
    return false;
  }
  else{
    $("#mail").after("<span class=\"emailValidInfo\">Valid e-mail</span>");
    return true;
  }
}

function checkValidUname(){
  var user = $("#uname").val();
  $(".userValidInfo").remove();
  if(user == ""){
    $("#uname").after("<span class=\"userValidInfo\">Username can't be empty</span>");
    return false;
  }
  return true;
}

function validate(){

  $(".submitInfo").remove();

  if(!checkValidUname() || !checkMatchingPasswords() || !checkValidEmail()){
    $("#registerSubmit").after("<span class=\"submitFailInfo\">Can't submit until errors are fixed</span>");
    return false;
  }
  else{
    $("register").submit();
  }
}

$(document).ready(setup);

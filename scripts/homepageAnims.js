function slideshow(){
  if(currDisplay == 0){
    currDisplay = 1;
    $("#0").fadeIn(1000, function(){
      $("#1").fadeIn(1000);
      $("#0").fadeOut(1000, slideshow);
    });

  }
  else{
    currDisplay = 0;
    $("#1").fadeIn(1000, function(){
      $("#0").fadeIn(1000);
      $("#1").fadeOut(1000, slideshow);
    });
  }
}


$(document).ready(slideshow);
var currDisplay = 0;

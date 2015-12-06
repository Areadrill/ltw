function slideshow(){
  if(currDisplay == 0){
    currDisplay = 1;
    setTimeout(function(){
      $("#1").fadeOut(4000, function(){
        $("#0").fadeIn(4000, slideshow);
      });
    }, 5000);
  }
  else{
    currDisplay = 0;
    setTimeout(function(){
        $("#1").fadeIn(4000, slideshow);
    }, 5000);
  }

}


$(document).ready(slideshow);
var currDisplay = 0;
  

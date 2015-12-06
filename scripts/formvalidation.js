$(document).ready(function(){
  $("input[type=text]").attr("pattern", "[A-Za-z0-9 _.@/?,!\"'/$]*").on('invalid', function(e){

    e.target.setCustomValidity("");
    console.log(e.target.validity.patternMismatch);
    if(e.target.validity.patternMismatch)
      e.target.setCustomValidity("Please use only alphanumeric characters");
  }).on('change', function(event){
    event.target.setCustomValidity("");
  });

});

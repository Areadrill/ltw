$(document).ready(
   function() {
    $("input[name=albumId]").each( function(){
      console.log($(this));
      var aid = $(this).parents("li[data-aid]").attr("data-aid");
      console.log(aid);
      $(this).attr("value", aid).parent("label").attr("hidden", "hidden");
    })
  } );

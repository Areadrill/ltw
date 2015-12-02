

$(document).ready(function ()
  {
    //add image event handler
    $("#addImage").click(function(){
      $("#uploadAlbumImage").removeAttr("hidden");
    });

    //submit image event handler
    $("form#uploadAlbumImage").submit(function(){
      event.preventDefault();

      var formData = new FormData($(this)[0]);
      console.log(formData);
      $.ajax({
        url: "database/action_uploadAlbumImage.php",
        type: 'POST',
        data: formData,
        async: false,
        success: function(response){
          var images = jQuery.parseJSON(response);
          var newImagePath = images[images.length-1]["fpath"];
          var newImageElement = $("ul.albumImageList li").first().clone().children("img").first().attr("src", newImagePath);
          newImageElement.appendTo("ul.albumImageList");
          $(this).attr("hidden", "hidden");
        },
        cache: false,
        contentType: false,
        processData: false
      });
    });


  });

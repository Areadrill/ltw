

$(document).ready(function ()
  {
    //add image event handler
    $("#addImage").click(function(){
      $("#uploadAlbumImage").removeAttr("hidden");
    });

    $("#renameAlbum").click(function(){
      $("#renameAlbumForm").removeAttr("hidden");
      $("form#renameAlbumForm label input[name=newName]").text("");
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
        async: true,
        success: function(response){
          var images = jQuery.parseJSON(response);
          var newImagePath = images[images.length-1]["fpath"];
          var newImageId = images[images.length-1]["iid"];
          var stringElement = "<li> <a href=\""+newImagePath+"\"> <img src=\""+newImagePath+"\" alt=\"image\"/> </a>  <button type=\"button\" class=\"deleteImage\" data-iid=\""+newImageId+"\">x</button> </li> ";
          var newImageElement = $(stringElement);
          newImageElement.appendTo("ul.albumImageList");
          $(this).attr("hidden", "hidden");
        },
        cache: false,
        contentType: false,
        processData: false
      });
    });

    $("form#renameAlbumForm").submit(function(){
      event.preventDefault();

      var formData = new FormData($(this)[0]);
      $.ajax({
        url: "database/action_renameAlbum.php",
        type: 'POST',
        data: formData,
        success: function(response){
          var json_response = jQuery.parseJSON(response);
            $("h1").first().text(json_response);
            $(this).attr("hidden", "hidden");
        },
        cache: false,
        contentType: false,
        processData: false
      });
    });

    $("button.deleteImage").click(function(){
      var parent = $(this).parent();
      $.post("database/action_deleteAlbumPhoto.php",
       {aid: $("#uploadImageAlbumNumber").attr("value"), iid: $(this).attr("data-iid"), csrf: $("#csrf").val()})
       .done(function(){parent.remove();});
    });

  });

$(document).ready(function(){
    setupHandlers();
  });

function updateFollowCount(count){
  $("p.eventInfo").first().text(count +" attending");
}

function setupHandlers(){
  $("#unfollowButton").click(function(){
    $("#unfollowButton").unbind();
    jQuery.post(
      "database/action_addFollower.php",
      {eventId: $("#eventIdField").val(), delete: 1},
      function(data){
        console.log(data);
        $("#unfollowButton").attr("id","followButton");
        $("#followButton").text("Follow");
        updateFollowCount(data);
        setupHandlers();
      });
      });
      $("#followButton").click(function(){
        $("#followButton").unbind();
        jQuery.post(
          "database/action_addFollower.php",
          {eventId: $("#eventIdField").val()},
          function(data){
            console.log(data);
            $("#followButton").attr("id","unfollowButton");
            $("#unfollowButton").text("Unfollow");
            updateFollowCount(data);
            setupHandlers();
          });
          });
}

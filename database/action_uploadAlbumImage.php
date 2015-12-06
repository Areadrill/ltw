<?
require_once('session_check.php');
require_once("album.php");
if(existsAlbum($_POST["albumId"])){
  addAlbumPhoto($_POST["albumId"],$_FILES["albumImage"]);
  $eventID = getAlbum($_POST["albumId"])["eid"];
  http_response_code(200);
  if(1){//!isset($_POST["return_json"]) && $_POST["return_json"]){
    echo json_encode(getAlbumImages(getAlbum($_POST["albumId"])));

  }
  else
    header("Location: ../manageAlbums.php?eid=".$eventID);
}
else{
  http_response_code(400);
  header("Location: ../homepage.php");
}

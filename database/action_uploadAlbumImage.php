<?
session_start();
require_once("album.php");
if(existsAlbum($_POST["albumId"])){
  addAlbumPhoto($_POST["albumId"],$_FILES["albumImage"]);
  $eventID = getAlbum($_POST["albumId"])["eid"];
  http_response_code(200);
  header("Location: ../manageAlbums.php?eid=".$eventID);
  exit;
}
else
  http_response_code(400);
  header("Location: ../homepage.php");

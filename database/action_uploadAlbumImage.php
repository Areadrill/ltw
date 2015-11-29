<?
session_start();
require_once("album.php");
if(existsAlbum($_POST["albumId"])){
  addAlbumPhoto($_POST["albumId"],$_FILES["albumImage"]);
  header('HTTP/1.0 200 OK; Location: ../homepage.php');
}
else
  header("Location: ../homepage.php");

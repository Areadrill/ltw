<?
session_start();
require_once("album.php");
if(existsAlbum($_POST["albumId"])){
  addAlbumPhoto($_POST["albumId"],$_FILES["albumImage"]);
  echo "OK";
}
else
  header("Location: ../homepage.php");

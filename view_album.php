<?
session_start();
require_once("database/album.php");
if(!isset($_GET['id'])){
  http_response_code(400);
  ?><p> No album was specified </p><?
  exit;
}

if(!existsAlbum($_GET['id'])){
  http_response_code(404);
  ?><p> The album does not exist in the server </p><?
  exit;
}
$album = getAlbum($_GET['id']);
$eventId = intval(getAlbum($_GET['id'])['eid']);
$albumImages = getAlbumImages($album);
?>

<!DOCTYPE html>
<html>
  <head>
    <?require_once('templates/header.php');?>
  </head>
  <body>
    <h1> <?echo $album['nome'];?></h1>
    <ul class="albumImageList">

    <? foreach($albumImages as $image){
      ?>
        <li>
          <img src="<?echo $image['fpath']; ?>" alt="Album image" />
        </li>
      <?
    }?>
  </ul>
  </body>
</html>

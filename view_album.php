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
    <?require_once('includes.php');?>
    <script type="text/javascript" src="scripts/view_album.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheets/album.css" >

  </head>
  <body>
    <?require_once('templates/header.php');?>
    <section id="album">
    <h1> <?echo $album['nome'];?></h1>

    <form id="uploadAlbumImage" enctype="multipart/form-data" hidden="hidden">
      <label class="hidden" hidden="hidden">Album Number:
        <input id="uploadImageAlbumNumber" type="number" name="albumId" min="0" value="<?echo $_GET['id']?>"/>
      </label>

      <label>Image File:
        <input type="file" name="albumImage" id="albumImage"/>
      </label>
      <input type="number" name="return_json" value="1" hidden="hidden"/>
      <input type="submit" value="Upload Image!">
    </form>

    <form id="renameAlbumForm" enctype="multipart/form-data" hidden="hidden">
      <label >New Album Name:
        <input type="text" name="newName" min="0" value=""/>
      </label>
      <input id="uploadImageAlbumNumber" type="number" name="aid" min="0" value="<?echo $_GET['id']?>" hidden="hidden"/>
      <input type="submit" value="Rename!">
    </form>

    <ul class="options">
        <li><a href="database/action_deleteAlbum.php?id=<?echo $_GET['id']?>">Delete Album</a></li>
        <li><a href="javascript:;" id="addImage">Add Image</a></li>
        <li><a href="javascript:;" id="renameAlbum">Rename Album</a></li>
    </ul>
    <ul class="albumImageList">

    <? foreach($albumImages as $image){
      ?>
        <li>
          <img src="<?echo $image['fpath']; ?>" alt="Album image" />
          <button type="button" class="deleteImage" data-iid="<?echo $image['iid'];?>">x</button>
        </li>
      <?
    }?>
  </ul>
</section>
  </body>
</html>

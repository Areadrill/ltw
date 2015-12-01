<?
function getAlbum($aid){
  require("connect.php");
  $stmt = $db->prepare('SELECT * FROM Album WHERE aid=?');
  $stmt->execute(array($aid));
  return $stmt->fetch(PDO::FETCH_ASSOC);
}
  function getAlbums($eid){
    require("connect.php");

  $stmt = $db->prepare('SELECT * FROM Album WHERE eid=?');
  $stmt->execute(array($eid));
  $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
  return $res;
}

function deleteAlbum($aid){
  require("connect.php");

  $stmt = $db->prepare("DELETE FROM Album WHERE aid=?");
  $res = $stmt->execute(array($aid));

  return $res;
}

function existsAlbum($aid){
  require("connect.php");

  $stmt = $db->prepare('SELECT * FROM Album WHERE aid=?');
  $stmt->execute(array($aid));
  $result = $stmt->fetch();
  if($result == FALSE)
    return $result;
  return TRUE;
}

function getAlbumAllowedEditors($aid){
  require("connect.php");

  $stmt = $db->prepare("SELECT EventOwner.uid FROM EventOwner, Album Where Album.eid=EventOwner.eid AND Album.aid=?");
  $stmt->execute(array($aid));
  $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
  return $result;
}

function uploadImage($file){
  require("connect.php");

  $imageFormats = array('png', 'jpg', 'jpeg');

  //verify image
  $path = $file["name"];
  $ext = pathinfo($path, PATHINFO_EXTENSION);
  var_dump($ext);
  $allowed = in_array($ext, $imageFormats);
  var_dump($allowed);
  if($allowed){
    $filename = "/images/albums/".uniqid("",true).".".$ext;
    var_dump($filename);
    move_uploaded_file($file["tmp_name"], $filename);
    require("connect.php");
    $stmt = $db->prepare("INSERT INTO Image values(null, ?)");
    $stmt->execute(array($filename));
    return $filename;
  }

  return $allowed;
}

function addAlbumPhoto($albumId, $photo){
require("connect.php");
  $uploadResult = uploadImage($photo);
  if($uploadResult){

    $query = $db->prepare("SELECT iid FROM Image WHERE fpath=?");
    $query->execute(array($uploadResult));
    $iid = $query->fetch()[0];
    $stmt = $db->prepare("INSERT INTO ImageAlbum values(?,?)");
    $stmt->execute(array( $iid, $albumId));
  }
}

  function createAlbum($eventId, $nome){
    require("connect.php");
    $stmt = $db->prepare('INSERT INTO Album values(null, ?, ?)');
    $stmt->execute(array($nome, $eventId));
  }

  function getAlbumThumbPath($album){
    require("connect.php");
    $stmt = $db->prepare('SELECT fpath FROM Image, ImageAlbum WHERE ImageAlbum.iid=Image.iid AND ImageAlbum.aid=?');
    $res = $stmt->execute(array($album['aid']));
    if($res){

     return  $stmt->fetch()[0];
   }
    else
      return false;
  }

  function getAlbumImages($album){
    require("connect.php");
    $stmt = $db->prepare('SELECT fpath FROM Image, ImageAlbum WHERE ImageAlbum.iid=Image.iid AND ImageAlbum.aid=?');
    $stmt->execute(array($album['aid']));
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }


  function printAlbumThumb($album){
    $path = getAlbumThumbPath($album);
    ?>

    <?
  }


?>

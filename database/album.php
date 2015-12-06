<?
function isMainAlbum($aid){
  require("connect.php");
    $stmt = $db->prepare("SELECT * FROM Album, ImageAlbum, Event WHERE Album.aid=? AND event.eid=album.eid AND ImageAlbum.aid=Album.aid AND event.eimage=ImageAlbum.iid");
    $stmt->execute(array($aid));
    $res = $stmt->fetch();
    if(!$res){
      return false;
    }
    else {
      return true;
    }
  }

function imageInAlbum($iid, $aid){
  require("connect.php");
  $stmt = $db->prepare("SELECT iid FROM ImageAlbum WHERE aid=?");
  $stmt->execute(array($aid));
  $res = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
  return in_array($iid, $res);
}

function renameAlbum($aid, $newName){
  require("connect.php");
  $stmt = $db->prepare("UPDATE Album SET nome=? WHERE aid=?");
  $res = $stmt->execute(array($newName, $aid));
  return $res;
}

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
  var_dump($aid);
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

function uploadImage($file, $eid, $db){

  $imageFormats = array('png', 'jpg', 'jpeg');

  //verify image
  $path = $file["name"];
  $ext = pathinfo($path, PATHINFO_EXTENSION);
  $ext = strtolower($ext);
  $allowed = in_array($ext, $imageFormats) || is_uploaded_file($file["tmp_name"]) || file_exists($file["tmp_name"]);
  if($allowed){
    $filename = "../images/".$eid.'/'.uniqid("",true).".".$ext;
    $fpath = PUBLIC_PATH.$filename;

    $res = move_uploaded_file($file["tmp_name"], $filename);
    if(!$res){
      http_response_code(500);
      exit;
    }
    $stmt = $db->prepare('INSERT INTO Image values(null, ?)');
    $stmt->execute(array(substr($filename,3)));
    return $db->lastInsertId();
  }

  return $allowed;
}

function addAlbumPhoto($albumId, $photo){
require("connect.php");

  $stmt = $db->prepare('SELECT eid FROM Album WHERE aid=?');
  $stmt->execute(array($albumId));
  $eventId = $stmt->fetch();

  $uploadResult = uploadImage($photo, $eventId['eid'], $db);
  if($uploadResult){
    $query = $db->prepare("SELECT iid FROM Image WHERE fpath=?");
    $query->execute(array($uploadResult));
    $iid = $query->fetch()["iid"];
    $stmt = $db->prepare("INSERT INTO ImageAlbum values(?,?)");
    $stmt->execute(array( $uploadResult, $albumId));
  }
}

  function createAlbum($eventId, $nome){
    require("connect.php");
    $stmt = $db->prepare('INSERT INTO Album values(null, ?, ?)');
    $res = $stmt->execute(array($nome, $eventId));
    return $res;
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
    $stmt = $db->prepare('SELECT fpath, Image.iid FROM Image, ImageAlbum WHERE ImageAlbum.iid=Image.iid AND ImageAlbum.aid=?');
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

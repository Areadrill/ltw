<?

  function getAlbums($eid){
    require("connect.php");

  $stmt = $db->prepare('SELECT * FROM Album WHERE eid=?');
  $stmt->execute(array($eid));
  $res = ($stmt->fetchAll(PDO::FETCH_ASSOC));
  return $res;
}

function existsAlbum($aid){
  require("connect.php");

  $stmt = $db->prepare('SELECT * FROM Almbum WHERE aid=?');
  $stmt->execute(array($aid));
  $result = $stmt->fetch();
  if($result == FALSE)
    return $result;
  return TRUE;
}

function uploadImage($file){
  require("connect.php");

  $imageFormats = array('.png', '.jpg', '.jpeg');

  //verify image
  $path = $file["name"];
  $ext = pathinfo($path, PATHINFO_EXTENSION);
  $allowed = in_array($ext, $imageFormats);

  if($allowed){
    $filename = tempnam('../images/albums', '');
    unlink($filename);
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
    $iid = $query->fetch();
    $stmt = $db->prepare("INSERT INTO ImageAlbum values(?,?)");
    $stmt->execute(array($albumId, $iid));
  }
}

  function createAlbum($eventId, $nome){
    require("connect.php");

    $stmt = $db->prepare('INSERT INTO Album VALUES(null, ?, ?)');
    return $stmt->execute(array($nome, $eventId));
  }

  function getAlbumThumbPath($album){
    require("connect.php");

    $stmt = $db->prepare('SELECT fpath FROM Image, ImageAlbum WHERE ImageAlbum.iid=Image.iid AND ImageAlbum.aid=?');
    $res = $stmt->execute(array($album['aid']));
    if($res){
     return  $stmt->fetch();
   }
    else
      return true;
  }


  function printAlbumThumb($album){
    $path = getAlbumThumbPath($album);
    ?>

    <?
  }


?>

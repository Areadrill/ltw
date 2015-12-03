<? //ISTO NAO VERIFICA SE HA OUTROS EVENTOS CRIADOS PELO MSM USER COM NOME IGUAL
session_start();
if(!isset($_SESSION['username'])){
  header('Location: ../homepage.php');
}

require_once('connect.php');
$name = $_POST['eventName'];
if(!$name){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}

$date = $_POST['eventDate'];
if(!$date){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}

$desc = $_POST['eventDescription'];
if(!$desc){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}

$type = $_POST['eventType'];
if(!$type){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}

$showing = $_POST['eventShowing'];
if(!$showing){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}

$eventId = $_POST['eventId'];

$rootFileName = '../images/'.$eventId;
$originalsFN = $rootFileName.'/originals';
$thumbsFN = $rootFileName.'/thumbs';

if($_FILES['eventImage']['name']){
  $imageFormats = array('.png', '.jpg', '.jpeg'); //por em JSON?
  $imageNotImage = TRUE;
  for($i = 0; $i < count($imageFormats); $i++){
    if(strpos($_FILES['eventImage']['name'], $imageFormats[$i], strlen($_FILES['eventImage']['name']) -4) !== FALSE){
      $imageNotImage = FALSE;
      $ext = $imageFormats[$i];
      break;
    }
  }
  if(isset($imageNotImage) && !$imageNotImage){
    $originalImagePath = $originalsFN.'/'.$_FILES['eventImage']['name'];
    move_uploaded_file($_FILES['eventImage']['tmp_name'], $originalImagePath);
    $imageSmall = imagecreatetruecolor(851, 315);
    $originalInfo = getimagesize($originalImagePath);

    switch($ext){
      case '.png':
        $original = imagecreatefrompng($originalImagePath);
        imagecopyresized($imageSmall, $original, 0, 0, 0, 0, 851, 315, $originalInfo[0], $originalInfo[1]);
        $thumbImagePath = $thumbsFN.'/thumb_'.$_FILES['eventImage']['name'];
        imagepng($imageSmall, $thumbImagePath);
        break;
      case '.jpeg': //intentional
      case '.jpg':
        $original = imagecreatefromjpeg($originalImagePath);
        imagecopyresized($imageSmall, $original, 0, 0, 0, 0, 851, 315, $originalInfo[0], $originalInfo[1]);
        $thumbImagePath = $thumbsFN.'/thumb_'.$_FILES['eventImage']['name'];
        imagejpeg($imageSmall, $thumbImagePath);
        break;
      default:
        break;
    }
    $thumbImagePath = $thumbsFN.'/thumb_'.$_FILES['eventImage']['name'];
    $stmt = $db->prepare('INSERT INTO Image values(null, ?)');
    $filePath = substr($thumbImagePath, 3);
    $stmt->execute(array($filePath));
    $imgId = $db->lastInsertId();

    $stmt = $db->prepare('SELECT aid FROM Album WHERE nome=? AND eid=?');
    $albumName = $eventId.'_defaultAlbum';
    $stmt->execute(array($albumName, $eventId));
    $albumId = $stmt->fetch();

    $stmt = $db->prepare('INSERT INTO ImageAlbum values(?, ?)');
    $stmt->execute(array($imgId, $albumId['aid']));
  }
  $imageChanged = TRUE;
}


if(isset($imageChanged) && $imageChanged === TRUE){
  $stmt = $db->prepare('UPDATE Event SET ename=?, edate=?, description=?, type=?, eimage=?, private=? WHERE eid=?');
  $stmt->execute(array($name, $date, $desc, $type, $imgId, $showing, $eventId));
}
else{
  $stmt = $db->prepare('UPDATE Event SET ename=?, edate=?, description=?, type=?, private=? WHERE eid=?');
  $stmt->execute(array($name, $date, $desc, $type, $showing, $eventId));
}
header('Location: ../event.php?id='.$eventId['eid']);

?>

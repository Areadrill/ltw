<? //ISTO NAO VERIFICA SE HA OUTROS EVENTOS CRIADOS PELO MSM USER COM NOME IGUAL
require_once('session_check.php');
if(!isset($_SESSION['username'])){
  http_response_code(403);
  header('Location: ../homepage.php');
  exit();
}

if(!isset($_POST['eventName']) || !isset($_POST['eventDate']) || !isset($_POST['eventDescription']) || !isset($_POST['eventType']) || !isset($_POST['eventShowing'])){
  http_response_code(400);
  header('Location: ../createEvent.php');
  exit();
}

if(strlen('eventName') == 0 || strlen('eventName') > 25 || strlen('eventDescription') == 0 || strlen('eventDescription') > 1000){
  http_response_code(400);
  header('Location: ../createEvent.php');
  exit();
}


require_once('connect.php');

$eventId = $_POST['eventId'];

$stmt = $db->prepare('SELECT uid FROM EventOwner WHERE eid=?');
$stmt->execute(array($eventId));
$owner = $stmt->fetch();

if($_SESSION['id'] !== $owner['uid']){
  http_response_code(403);
  header('Location: ../homepage.php');
  exit();
}

$stmt = $db->prepare('SELECT ename FROM Event WHERE eid=?');
$stmt->execute(array($_POST['eventId']));
$oldName = $stmt->fetch();

if($oldName['ename'] != $_POST['eventName']){
  $stmt = $db->prepare('SELECT ename FROM Event WHERE ename=?');
  $stmt->execute(array($_POST['eventName']));
  $otherEvent = $stmt->fetch();
  if($otherEvent){
    http_response_code(400);
    header('Location: ../createEvent.php?fail=1');
    exit();
  }
}

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
  $stmt->execute(array($_POST['eventName'], $_POST['eventDate'], $_POST['eventDescription'], $_POST['eventType'], $imgId, $_POST['eventShowing'], $eventId));
}
else{
  $stmt = $db->prepare('UPDATE Event SET ename=?, edate=?, description=?, type=?, private=? WHERE eid=?');
  $stmt->execute(array($_POST['eventName'], $_POST['eventDate'], $_POST['eventDescription'], $_POST['eventType'], $_POST['eventShowing'], $eventId));
}
header('Location: ../event.php?id='.$eventId['eid']);

?>

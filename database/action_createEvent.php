<?
session_start();
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

if(!isset($_FILES['eventImage']) || $_FILES['eventImage']['error'] == 1){
  http_response_code(400);
  header('Location: ../createEvent.php?fail=1');
  exit();
}

$stmt = $db->prepare('SELECT eid FROM Event WHERE ename=?');
$stmt->execute(array($_POST['eventName']));
$event = $stmt->fetch();
if($event['eid']){
  http_response_code(400);
  header('Location: ../createEvent.php?fail=1');
  exit();
}


$stmt = $db->prepare('INSERT INTO Event values(null, ?, ?, ?, ?, null, ?)');
$stmt->execute(array($_POST['eventName'], $_POST['eventDate'], $_POST['eventDescription'], $_POST['eventType'], $_POST['eventShowing']));
$eventId = $db->lastInsertId();

$rootFileName = '../images/'.($eventId);
$originalsFN = $rootFileName.'/originals';
$thumbsFN = $rootFileName.'/thumbs';

$success = mkdir($rootFileName);
if(!$success){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
$success = mkdir($originalsFN);
if(!$success){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
$success = mkdir($thumbsFN);
if(!$success){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}

$imageFormats = array('png', 'jpg', 'jpeg');

$ext = pathinfo($_FILES['eventImage']['name'], PATHINFO_EXTENSION);

$ext = strtolower($ext);


$imageNotImage = !in_array($ext, $imageFormats);

if(!$imageNotImage){
  $originalImagePath = $originalsFN.'/'.$_FILES['eventImage']['name'];
  move_uploaded_file($_FILES['eventImage']['tmp_name'], $originalImagePath);
  //smaller image
  /*$thumbImagePath = $thumbsFN.'/thumb_'.$_FILES['eventImage']['name'];
  $imagick = new Imagick();
  $imagick->readImage($originalImagePath);
  $imagick->resizeImage(640, 480, Imagick::FILTER_LANCZOS, 1);
  $imagick->writeImage($thumbImagePath);*/
  $imageSmall = imagecreatetruecolor(851, 315);
  $originalInfo = getimagesize($originalImagePath);

  switch($ext){
    case 'png':
      $original = imagecreatefrompng($originalImagePath);
      imagecopyresized($imageSmall, $original, 0, 0, 0, 0, 851, 315, $originalInfo[0], $originalInfo[1]);
      $thumbImagePath = $thumbsFN.'/thumb_'.$_FILES['eventImage']['name'];
      imagepng($imageSmall, $thumbImagePath);
      break;
    case 'jpeg': //intentional
    case 'jpg':
      $original = imagecreatefromjpeg($originalImagePath);
      imagecopyresized($imageSmall, $original, 0, 0, 0, 0, 851, 315, $originalInfo[0], $originalInfo[1]);
      $thumbImagePath = $thumbsFN.'/thumb_'.$_FILES['eventImage']['name'];
      imagejpeg($imageSmall, $thumbImagePath);
      break;
    default:
      break;
  }
}
else{
  rmdir('../images/'.($eventId).'/thumbs_small');
  rmdir('../images/'.($eventId).'/originals');
  rmdir('../images'.($eventId));
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}



$stmt = $db->prepare('INSERT INTO Image values(null, ?)');
$filePath = substr($thumbImagePath, 3);
$stmt->execute(array($filePath));
$imgId = $db->lastInsertId();

$stmt = $db->prepare('UPDATE Event SET eimage=? WHERE eid=?');
$stmt->execute(array($imgId, $eventId));

$stmt = $db->prepare('INSERT INTO EventOwner values(?, ?)');
$stmt->execute(array($_SESSION['id'], $eventId));

$stmt = $db->prepare('INSERT INTO EventFollower values(?, ?)');
$stmt->execute(array($eventId, $_SESSION['id']));

$stmt = $db->prepare('INSERT INTO Album values(null, ?, ?)');
$albumName = $eventId.'_defaultAlbum';
$stmt->execute(array($albumName, $eventId));
$albumId = $db->lastInsertId();

$stmt = $db->prepare('INSERT INTO ImageAlbum values(?, ?)');
$stmt->execute(array($imgId, $albumId));

header('Location: ../event.php?id='.$eventId);

?>

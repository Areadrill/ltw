<? //ISTO NAO VERIFICA SE HA OUTROS EVENTOS CRIADOS PELO MSM USER COM NOME IGUAL
session_start();
if(!isset($_SESSION['username'])){
  header('Location: ../homepage.php');
  exit();
}

require_once('connect.php');

$name = $_POST['eventName'];
if(!$name){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
echo $name;

$date = $_POST['eventDate'];
if(!$date){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
echo $date;

$desc = $_POST['eventDescription'];
if(!$desc){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
echo $desc;

$type = $_POST['eventType'];
if(!$type){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
echo $type;

$showing = $_POST['eventShowing'];
if(!$showing){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
echo $showing;

if(!isset($_FILES['eventImage'])){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}


$stmt = $db->prepare('INSERT INTO Event values(null, ?, ?, ?, ?, null, ?)');
$stmt->execute(array($name, $date, $desc, $type, $showing));
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
  rmdir('../images/'.($res['max']+1).'/thumbs_small');
  rmdir('../images/'.($res['max']+1).'/originals');
  rmdir('../images'.($res['max']+1));
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

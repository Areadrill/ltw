<? //ISTO NUM FOI TESTADO
session_start();
if(!isset($_SESSION['username'])){
  header('Location: ../homepage.php');
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
$rootFileName = '../images/'.$name;
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

$imageFormats = array('.png', '.jpg', '.jpeg', '.tiff', '.tif'); //por em JSON?
$imageNotImage = TRUE;
for($i = 0; $i < count($imageFormats); $i++){
  if(strpos($_FILES['eventImage']['name'], $imageFormats[$i], strlen($_FILES['eventImage']['name']) -4) !== FALSE){
    $imageNotImage = FALSE;
    break;
  }
}
if(!$imageNotImage){
  $originalImagePath = $originalsFN.'/'.$_FILES['eventImage']['name'];
  move_uploaded_file($_FILES['eventImage']['tmp_name'], $originalImagePath);
  /*$imageSmall = imagecreatetruecolor(640, 480);
  imagecopyresized($imageSmall, $original, 0, 0, 0, 0, $mediumwidth, $mediumheight, $width, $height);
  $thumbImagePath = $thumbsFN.'/thumb_'.$_FILES['eventImage']['name'];
  imagejpeg($imageSmall, $thumbImagePath);*/ //Need to avriguate about image resizing
}
else{
  rmdir('../images/'.$name.'/thumbs_small');
  rmdir('../images/'.$name.'/originals');
  rmdir('../images'.$name);
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}

$stmt = $db->prepare('INSERT INTO Event values(null, ?, ?, ?, ?, ?)');
$stmt->execute(array($name, $date, $desc, $type, $showing));

$eventId = $db->lastInsertId();

$stmt = $db->prepare('INSERT INTO EventOwner values(?, ?)');
$stmt->execute(array($_SESSION['id'], $eventId));

$stmt = $db->prepare('INSERT INTO EventFollower values(?, ?)');
$stmt->execute(array($_SESSION['id'], $eventId));

$stmt = $db->prepare('INSERT INTO Album values(null, ?, ?)');
$albumName = $name.'_defaultAlbum';
$stmt->execute(array($albumName, $eventId));
$albumId = $db->lastInsertId();

$stmt = $db->prepare('INSERT INTO Image values(null, ?, ?)');
$filePath = $originalImagePath;
$stmt->execute(array($albumId, $filePath));

//reencaminhar para a pagina do evento?
header('Location: ../homepage.php')

?>

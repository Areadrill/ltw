<? //ISTO NAO VERIFICA SE HA OUTROS EVENTOS CRIADOS PELO MSM USER COM NOME IGUAL
session_start();
if(!isset($_SESSION['username'])){
  header('Location: ../homepage.php');
}

require_once('connect.php');
echo $_POST['eventId'];
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


$rootFileName = '../images/'.$name;
$originalsFN = $rootFileName.'/originals';
$thumbsFN = $rootFileName.'/thumbs';

if(isset($_FILES['eventImage'])){
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

    $stmt = $db->prepare('INSERT INTO Image values(null, ?)');
    $filePath = $originalImagePath;
    $stmt->execute(array($filePath));
    $imgId = $db->lastInsertId();

    $stmt = $db->prepare('SELECT aid FROM Album WHERE eid=? AND name = %_defaultAlbum');
    $stmt->execute(array($_POST['eventId']));
    $albumId = $stmt->fetch();

    $stmt = $db->prepare('INSERT INTO ImageAlbum values(?, ?)');
    $stmt->execute($imgId, $albumId['aid']);
  }
  $imageChanged = TRUE;
}


if(isset($imagechanged)){
  $stmt = $db->prepare('UPDATE Event SET ename=?, edate=?, description=?, type=?, eimage=?, private=?');
  $stmt->execute(array($name, $date, $desc, $type, $imgId, $showing));
}
else{
  $stmt = $db->prepare('UPDATE Event SET ename=?, edate=?, description=?, type=?, private=?');
  $stmt->execute(array($name, $date, $desc, $type, $showing));
}
  $eventId = $db->lastInsertId();
header('Location: ../event.php?id='.$eventId);

?>

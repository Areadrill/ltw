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

if(!isset($_POST['eventImage'])){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
$success = mkdir('../images/'.$name);
if(!$success){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
$success = mkdir('../images/'.$name.'/originals');
if(!$success){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}
$success = mkdir('../images/'.$name.'/thumbs_small');
if(!$success){
  //de volta pro createEvent com indicaçao q ta fdido (ou fazer isso com js)
}

//falta aqui meter a imagem nas pastas 

/*$stmt = $db->prepare('INSERT INTO Event values(null, ?, ?, ?, ?, ?)');
$stmt->execute(array($name, $date, $desc, $type, $showing));

$eventId = $db->lastInsertId();

$stmt = $db->prepare('INSERT INTO EventOwner values(?, ?)');
$stmt->execute(array($_SESSION['id'], $eventId));

$stmt = $db->prepare('INSERT INTO Album values(null)');
$stmt->execute();
$albumId = $db->lastInsertId();

$stmt = $db->prepare('INSERT INTO Image values(null, ?, ?)');
$filePath = "derp";
$stmt->execute(array($albumId, $filePath));*/

//reencaminhar para a pagina do evento?

//NADA DISTO FOI TESTADO

?>

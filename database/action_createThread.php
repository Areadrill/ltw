<?
session_start();
if(!isset($_SESSION['username']) || !isset($_POST['threadTitle']) || !isset($_POST['threadText']) || !isset($_POST['eventId'])){
  header('Location: ../homepage.php');
}

require_once('connect.php');
$stmt = $db->prepare('SELECT count(tid) FROM Thread WHERE title=?');
$stmt->execute(array($_POST['threadTitle']));
$count = $stmt->fetch();

if(count != 0){
  //mandar pra traz a dizer q ja exite um thread com esse nome (em vez doq ta abaixo)
  header('Location: ../forum.php?id='.$_POST['eventId']);
}

$stmt = $db->prepare('INSERT INTO Thread values(null, ?, ?, ?, ?)');
$stmt->execute(array($_POST['threadTitle'], $_SESSION['username'], $_POST['eventId'], $_POST['threadText']));
$count = $stmt->fetch();

header('Location: ../homepage.php');
?>

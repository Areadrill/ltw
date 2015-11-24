<?
session_start();
if(!isset($_SESSION['username'])){
  header('Location: ../homepage.php');
}
require_once('connect.php');
$stmt = $db->prepare('SELECT uid FROM EventOwner WHERE eid=?');
$stmt->execute(array($_GET['eventId']));
$owner = $stmt->fetch();

if($_SESSION['username'] != $owner['uid']){
    header('Location: ../homepage.php');
}

$stmt = $db->prepare('INSERT INTO EventFollower values(?, ?)');
$stmt->execute(array($_GET['eventId'], $_SESSION['id']));

header('Location: ../event.php?id='.$_GET['eventId']);
?>

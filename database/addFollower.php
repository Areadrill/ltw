<?
session_start();
if(!isset($_SESSION['username'])){
  header('Location: ../homepage.php');
  exit();
}
require_once('connect.php');
$stmt = $db->prepare('SELECT uid FROM EventFollower WHERE eid=? AND uid=?');
$stmt->execute(array($_GET['eventId'], $_SESISON['username']));
$isFollowing = $stmt->fetch();

if($isFollowing){
    header('Location: ../homepage.php');
    exit();
}

$stmt = $db->prepare('INSERT INTO EventFollower values(?, ?)');
$stmt->execute(array($_GET['eventId'], $_SESSION['id']));

header('Location: ../event.php?id='.$_GET['eventId']);
?>

<?
session_start();
if(!isset($_SESSION['username'])){
  header('Location: ../homepage.php');
  exit();
}
if(isset($_POST['users'])){
  followarray($_POST['users']);
  header('Location: ../homepage.php');
  exit();
}

require_once('connect.php');

$stmt = $db->prepare('SELECT private FROM Event WHERE eid=?');
$stmt->execute(array($_GET['eventId']));
$private = $stmt->fetch();
if($private['private'] === 1){
  header('Location: ../homepage.php');
}

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

function followArray($followArr){
  require_once('connect.php');
  $stmt = $db->prepare('SELECT uid FROM EventFollower WHERE eid =?');
  $stmt->execute(array($_GET['eventId']));
  $alreadyFollowing = $stmt->fetchAll();
  foreach($followArr as $pFollower){
    if(!in_array($pFollower, $alreadyFollowing, TRUE)){
      $stmt = $db->prepare('INSERT INTO EventFollower values(?, ?)');
      $stmt->execute(array($_GET['eventId'], $pFollower));
    }
  }
}
?>

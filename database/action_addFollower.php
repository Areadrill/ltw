<?
require_once('session_check.php');
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
$stmt->execute(array($_POST['eventId']));
$private = $stmt->fetch();
if($private['private'] === 1){
  http_response_code(403);
  exit;
}

$stmt = $db->prepare('SELECT uid FROM EventFollower WHERE eid=? AND uid=?');
$stmt->execute(array($_POST['eventId'], $_SESSION['id']));
$isFollowing = $stmt->fetch(PDO::FETCH_COLUMN, 0);

if($isFollowing && !isset($_POST["delete"])){
    http_response_code(409);
    exit();
}
else if(!$isFollowing && isset($_POST["delete"])){
  http_response_code(409);
  exit();
}

if(!isset($_POST["delete"])){
$stmt = $db->prepare('INSERT INTO EventFollower values(?, ?)');
$res = $stmt->execute(array($_POST['eventId'], $_SESSION['id']));
}

if(isset($_POST["delete"])){
  $stmt = $db->prepare('DELETE FROM EventFollower where eid=? and uid=?');
  $res = $stmt->execute(array($_POST['eventId'], $_SESSION['id']));
}

if(!$res){
  http_response_code(500);
}
else {
  http_response_code(200);
  $stmt = $db->prepare("SELECT COUNT(uid) FROM EventFollower WHERE eid=?");
  $stmt->execute(array($_POST['eventId']));
  $res = $stmt->fetch()["COUNT(uid)"];
  echo $res;
}

function followArray($followArr){
  require_once('connect.php');
  $stmt = $db->prepare('SELECT uid FROM EventFollower WHERE eid =?');
  $stmt->execute(array($_POST['eventId']));
  $alreadyFollowing = $stmt->fetchAll();
  foreach($followArr as $pFollower){
    if(!in_array($pFollower, $alreadyFollowing, TRUE)){
      $stmt = $db->prepare('INSERT INTO EventFollower values(?, ?)');
      $stmt->execute(array($_POST['eventId'], $pFollower));
    }
  }
}
?>

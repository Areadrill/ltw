<?
require_once('session_check.php');
if(!isset($_SESSION['username']) || !isset($_POST['threadTitle']) || !isset($_POST['threadText']) || !isset($_POST['eventId'])){
  http_response_code(400);
  header('Location: ../index.php');
  exit();
}

if(strlen($_POST['threadTitle']) == 0 || strlen($_POST['threadTitle']) > 1000){
  http_response_code(400);
  header('Location: ../index.php');
  exit();
}

require_once('connect.php');
$stmt = $db->prepare('SELECT count(tid) FROM Thread WHERE title=? AND event=?');
$stmt->execute(array($_POST['threadTitle'], $_POST['eventId']));
$count = $stmt->fetch();
if($count["count(tid)"] != 0){
  //mandar pra traz a dizer q ja exite um thread com esse nome (em vez doq ta abaixo)
  http_response_code(422);
  exit();
}

$stmt = $db->prepare('INSERT INTO Thread values(null, ?, ?, ?, ?)');
$stmt->execute(array($_POST['threadTitle'], $_SESSION['id'], $_POST['eventId'], $_POST['threadText']));

http_response_code(200);
?>
<div class="thread">
  <h2><a href="thread.php?id=<?echo $db->lastInsertId();?>"><?echo $_POST['threadTitle'];?></a></h2> <p>Created by: <?echo $_SESSION['username'];?></p>
  <p>Comments:</p>
</div>

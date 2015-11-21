<?
if(!isset($_SESSION['id'])){
  header('Location: homepage.php');
}

function getEvent($id){
  $db = new PDO('sqlite:database/db/EventagerDB.db');
  $stmt = $db->prepare('SELECT * FROM Event WHERE eid=?');
  $stmt->execute(array($id));
  $res = $stmt->fetch();

  $stmt = $db->prepare('SELECT fpath FROM Image WHERE iid=?');
  $stmt->execute(array($res['eimage']));
  $imgPath = $stmt->fetch();

  $stmt = $db->prepare('SELECT uid FROM EventOwner WHERE eid=?');
  $stmt->execute(array($id));
  $owner = $stmt->fetch();

  $stmt = $db->prepare('SELECT uname FROM User WHERE uid=?');
  $stmt->execute(array($owner['uid']));
  $creatorName = $stmt->fetch();

  $stmt = $db->prepare('SELECT count(uid) AS attendees FROM EventFollower WHERE eid=?');
  $stmt->execute(array($id));

  $attendeeCount = $stmt->fetch();
  //print_r($attendeeCount);
?>
<img src="<?echo $imgPath['fpath']?>" id="mainimage"/>
</br>
<h1 id="eventTitle"><?echo $res['ename']?></h1> <p> created by <?echo $creatorName['uname']?></p>
<p><?echo $attendeeCount['attendees']?> attending</p>
<p>When: <?echo $res['edate']?></p>
<p>Description: <?echo $res['description']?></p>
<? //ainda falta meter o forum funcional, botao d follow, opçoes pro owner, ...
}

?>

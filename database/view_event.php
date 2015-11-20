<? session_start();
if(!isset($_SESSION['id'])){
  header('Location: homepage.php')
}
require_once('database/connect.php');
function getEvent($id){
  $stmt = $db->prepare('SELECT * FROM Event WHERE eid=?');
  $stmt->execute(array($id));
  $res = $stmt->fetch();

  $stmt = $db->prepare('SELECT path FROM Image WHERE iid=?');
  $stmt->execute(array($res['eimage']));
  $imgPath = $stmt->fetch();

  $stmt = $db->prepare('SELECT uid FROM EventOwner WHERE eid=?');
  $stmt->execute(array($id));

  $owner = $stmt->fetch();

  $stmt = $db->prepare('SELECT count(uid) AS attendees FROM EventFollower WHERE eid=?');
  $stmt->execute(array($id));

  $attendeeCount = $stmt->fetch();
//to be continued
}

?>

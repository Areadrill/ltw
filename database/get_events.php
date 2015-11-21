<?//isto n precisa d ser um ficheiro novo...
if(!isset($_SESSION['id'])){
  header('Location: homepage.php');
}

function getEvents($ownerId){
  $db = new PDO('sqlite:database/db/EventagerDB.db');

  $stmt = $db->prepare('SELECT eid FROM EventOwner WHERE uid=?');
  $stmt->execute(array($ownerId));
  $events = $stmt->fetchAll();

  foreach ($events as $event) {
    $stmt = $db->prepare('SELECT ename, edate FROM Event WHERE eid=?');
    $stmt->execute(array($event['eid']));
    $res = $stmt->fetch();

    $stmt = $db->prepare('SELECT count(uid) AS attendees FROM EventFollower WHERE eid=?');
    $stmt->execute(array($event['eid']));
    $attending = $stmt->fetch();
    ?>
      <p class="event"> <?echo $res['ename']?>  <?echo $res['edate']?> - <?echo $attending['attendees']?> attending </p> <ul id="options"> <li>Edit</li>
                                                                                                                                           <li>Delete<li></ul>
     </br>
  <?
  }


}
?>

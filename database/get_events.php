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
      <p class="event"> <a href="event.php?id=<?echo $event['eid']?>"><?echo $res['ename']?></a>  <?echo $res['edate']?> - <?echo $attending['attendees']?> attending </p>
      <ul id="options">
        <li><a href="editEvent.php?id=<?echo $event['eid']?>">Edit</a></li>
        <li>Delete<li>
      </ul>
     </br>
  <?
  }


}

function getEventsByName($searchString){
  $db = new PDO('sqlite:database/db/EventagerDB.db');
  $searchFormatted = getExpression($searchString);
  $stmt = $db->prepare("SELECT * FROM Event WHERE ename LIKE ? ");
  $stmt->execute(array($searchFormatted));
  $events = $stmt->fetchAll();

  foreach($events as $event){
    $stmt = $db->prepare('SELECT count(uid) AS attendees FROM EventFollower WHERE eid=?');
    $stmt->execute(array($event['eid']));
    $attending = $stmt->fetch();
    ?>
    <p class="event"> <a href="event.php?id=<?echo $event['eid']?>"><?echo $event['ename']?></a>  <?echo $event['edate']?> - <?echo $attending['attendees']?> attending </p>
   </br>
  <?
  }


}
//Produces a string formatted to be used in the query of the calling function
function getExpression($searchString){
  $str = '%';
  $array = explode(" ", $searchString);
  foreach($array as $word){
    $str .= $word.'%';
  }
  echo $str;
  return $str;
}
?>

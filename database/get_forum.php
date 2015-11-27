<?
function getEventThreads($eventId){
  $db = new PDO('sqlite:database/db/EventagerDB.db');
  $stmt = $db->prepare('SELECT * FROM Thread WHERE event=? ORDER BY tid DESC'); //ordenado do maior tid pro mais piqueno
  $stmt->execute(array($eventId));
  $threads = $stmt->fetchAll();

  $stmt = $db->prepare('SELECT ename FROM Event WHERE eid=?');
  $stmt->execute(array($eventId));
  $eventName = $stmt->fetch();

  ?>
  <h1> Thread for <a href="event.php?id=<?echo $eventId?>"><?echo $eventName['ename']; //por imagem por cima??></a></h1>
  <form id="formzinho" action="createThread.php" method="post">
    <input type="hidden" name="eventId" value="<?echo $eventId?>">
    <a href="createThread.php" onclick="document.getElementById('formzinho').submit(); return false;">Create your own thread</a>
  </form>
  <?foreach($threads as $thread){
    $stmt = $db->prepare('SELECT uname FROM User WHERE uid=?');
    $stmt->execute(array($thread['creator']));
    $creator = $stmt->fetch();

    $stmt = $db->prepare('SELECT count(cid) AS comments FROM Comment WHERE thread=?');
    $stmt->execute(array($thread['tid']));
    $comments = $stmt->fetch();

    ?>

    <h2><?echo $thread['title'];?></h2> <p>Created by: <?echo $thread['creator'];?></p>
    <p>Comments: <?echo $comments['comments'];?></p>

  <?}
}


?>

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
  <section id="threads">
  <div id="threadIntro">
    <h1> Threads  </h1>
    <form id="formzinho" action="createThread.php" method="post">
      <input id="eventIdHidden" type="hidden" name="eventId" value="<?echo $eventId?>">
      <a id="createThreadButton" href="javascript:;">Create your own thread</a>
    </form>
  </div>
  <div id="threadCreation">
    <form id="threadCreation" action="database/action_createThread.php" method="post" enctype="multipart/form-data">
      <label>Title:</label>
      <input type="text" name="threadTitle"/>
      <br>
      <label>Text:</label>
      <br>
      <textarea id="threadText" rows="8" cols="40" maxlength="1000" name="threadText"></textarea>
      <br>
      <input type="submit" value="Create thread!"/>
     </form>
  </div>

  <?foreach($threads as $thread){
    $stmt = $db->prepare('SELECT uname FROM User WHERE uid=?');
    $stmt->execute(array($thread['creator']));
    $creator = $stmt->fetch();

    $stmt = $db->prepare('SELECT count(cid) AS comments FROM Comment WHERE thread=?');
    $stmt->execute(array($thread['tid']));
    $comments = $stmt->fetch();

    ?>
    <div class="thread">
      <h2><a href="thread.php?id=<?echo $thread['tid']?>"><?echo $thread['title'];?></a></h2> <p>Created by: <?echo $thread['creator'];?></p>
      <p>Comments: <?echo $comments['comments'];?></p>
    </div>
  <?}?>
</section>
<?
}


?>

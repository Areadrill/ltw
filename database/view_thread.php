<?
function getThread($id){
  $db = new PDO('sqlite:database/db/EventagerDB.db');
  $stmt = $db->prepare('SELECT * FROM Thread WHERE tid=?');
  $stmt->execute(array($id));
  $thread = $stmt->fetch();

  $stmt = $db->prepare('SELECT private FROM Event WHERE eid=?');
  $stmt->execute(array($thread['event']));
  $isPrivate = $stmt->fetch();

  if($isPrivate['private']){
    $stmt = $db->prepare('SELECT uid FROM EventFollower WHERE eid=?');
    $stmt->execute(array($thread['event']));
    $followers = $stmt->fetchAll();
    if(!in_array($_SESSION['id'], $followers, TRUE)){
      header('Location: homepage.php');
      exit();
    }
  }

  $stmt = $db->prepare('SELECT * FROM Comment WHERE thread=?');
  $stmt->execute(array($id));
  $comments = $stmt->fetchAll();?>

  <h1><?echo $thread['title']?></h1> <p>Created by: <?echo $thread['creator']?></p>
  <p><?echo $thread['fulltext']?></p>
  <p>Want to comment? Scroll down or <a href="#writeComment">click here!</a></p>

  <?foreach($comments as $comment){?>
    <p><?echo $comment['content']?></p> <p class="userComment">by: <?echo $comment['user']?></p>
  <?}?>

  <label id="writeComment">Comment here</label>
  <form action="database/action_addComment.php" method="post" >
    <textarea rows="8" cols="80" name="comment"></textarea>
    <input type="hidden" name="threadId" value="<?echo $thread['tid']?>"/>
    <input type="submit" value="Comment" />
  </form>

<?}
?>

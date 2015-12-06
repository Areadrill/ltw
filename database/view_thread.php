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

  $stmt = $db->prepare('SELECT *  FROM Comment,User WHERE thread=? AND Comment.user=User.uid');
  $stmt->execute(array($id));
  $comments = $stmt->fetchAll();

  $stmt = $db->prepare('SELECT uname FROM User WHERE uid=?');
  $stmt->execute(array($thread['creator']));
  $uname = $stmt->fetch();
  ?>


  <h1><?echo $thread['title']?></h1> <p>Created by: <?echo $uname['uname']?></p>
  <p><?echo $thread['fulltext']?></p>
  <p>Want to comment? Scroll down or <a href="#writeComment">click here!</a></p>

  <?foreach($comments as $comment){
    ?>
    <p><?echo $comment['content']?></p> <p class="userComment">by: <?echo $comment['uname']?></p>
  <?}?>

  <label id="writeComment">Comment here</label>

  <form id="createComment" action="database/action_addComment.php" method="post" >
    <input type="hidden" name="csrf" value="<?echo $_SESSION['tok']?>" />
    <textarea id="commentText" rows="8" cols="80" name="comment" maxlength="512"></textarea>
    <input id="tid" type="hidden" name="threadId" value="<?echo $thread['tid']?>"/>
    <input type="submit" value="Comment" />
  </form>

<?}
?>

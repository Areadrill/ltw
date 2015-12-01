<?
if(!isset($_SESSION['id'])){
  header('Location: homepage.php');
  exit();
}

function getEvent($id){
  $db = new PDO('sqlite:database/db/EventagerDB.db');
  $stmt = $db->prepare('SELECT * FROM Event WHERE eid=?');
  $stmt->execute(array($id));
  $res = $stmt->fetch();

  $stmt = $db->prepare('SELECT fpath FROM Image WHERE iid=?');
  $stmt->execute(array($res['eimage']));
  $imgPath = $stmt->fetch();

  $stmt = $db->prepare('SELECT uid FROM EventFollower WHERE eid=?');
  $stmt->execute(array($res['eid']));
  $following = $stmt->fetchAll();

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

<? $alreadyFollowing = FALSE;
foreach($following as $follower){
  if($_SESSION['id'] === $follower['uid']){
    $alreadyFollowing = TRUE;
    break;
  }
}
if(!$alreadyFollowing){
  ?><p> You are currently not following this event. <a href="database/addFollower.php?eventId=<?echo $res['eid']?>">Follow now!</a></p>

<?}
else{
  ?><p> You are currently following this event </p><?
}?>

<h2>Albums</h2>
<ul>
<?
  require_once("database/album.php");
  $albums = getAlbums($id);
  foreach($albums as $album){
    $thumbPath = getAlbumThumbPath($album);
    ?>
    <li>
      <div class="album">
        <a href="view_album.php?id=<?echo $album['aid']?>" target="_blank">
          <img src="<? print($thumbPath); ?>" alt="<? echo $album['nome']?>" width="110" height="90"/>
          <p class="albumName"> <? echo $album['nome']; ?> </p>
        </a>
      </div>
    </li>
    <?
  }

?>
</ul>
<p> Want more information? Want to get in touch with other attendees and the event's managers? <a href="forum.php?id=<?echo $res['eid']?>">Check out the forum!</a></p>
<?
//ainda falta meter o forum funcional, opçoes pro owner, ...
}

?>

<?
if(!isset($_SESSION['id'])){
  header('Location: homepage.php');
  exit();
}

require_once('database/get_forum.php');

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
<section id="event">
<div id="coverImage">
<img src="<?echo $imgPath['fpath']?>" id="mainimage"/>
<h1 id="eventTitle"><span id="nameAndauthor"><?echo $res['ename']?> <br> <div id="author"> created by <?echo $creatorName['uname']?></div></span></h1>
</div>

<p class="eventInfo"><?echo $attendeeCount['attendees']?> attending</p>
<? $alreadyFollowing = FALSE;
foreach($following as $follower){
  if($_SESSION['id'] === $follower['uid']){
    $alreadyFollowing = TRUE;
    break;
  }
}
if(!$alreadyFollowing){
  ?><button id="followButton" class="eventInfo"> Follow </button>
<?//<a href="database/addFollower.php?eventId=<?echo $res['eid']\?\>">?>
<?}
else{
  ?><button id="unfollowButton" class="eventInfo"> Unfollow </button><?
}?>

<p id="date" class="eventInfo">When: <?echo $res['edate']?></p>

<div id="description">
<h1>Description:</h1>
  <p><?echo $res['description']?></p>
</div>


<div id="albums">
<h2>Albums</h2>
<ul>
<?
  require_once("database/album.php");
  $albums = getAlbums($id);
  foreach($albums as $album){
    $thumbPath = getAlbumThumbPath($album);
    ?>
    <li>
      <span class="album">
        <a href="view_album.php?id=<?echo $album['aid']?>" target="_blank">
          <img class="albumDisplay" src="<? print($thumbPath); ?>" alt="<? echo $album['nome']?>" width="110" height="90"/>
          <span class="albumName albumDisplay"> <? echo $album['nome']; ?> </span>
        </a>
      </span>
    </li>
    <?
  }

?>
</ul>
</div>
<?
getEventThreads($res['eid']);?>
</section>
<?
//ainda falta meter o forum funcional, opçoes pro owner, ...
}

?>

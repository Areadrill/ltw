<?
require_once('get_events.php');
function getUsersByName($searchString){
  $db = new PDO('sqlite:database/db/EventagerDB.db');

  $stmt = $db->prepare('SELECT * FROM User WHERE uname LIKE ?');
  $stmt->execute(array(getExpression($searchString)));
  $users = $stmt->fetchAll();?>

  <form action="invite.php?id=<?echo $_GET['id']?>" method="post">
    <input type="text" name="searchString" placeholder="Search for a user here">
    <input type="submit" value="Search" >
  </form>

  <form action="database/action_addFollower.php" method="post">

  <?if($searchString !== ''){foreach($users as $user){?>
    <label><?echo $user['uname']?></label> <input type="checkbox" name="users[]" value="<?echo $user['uid']?>" > <br>
  <?}?>

    <input type="submit" value="Invite these people" >
<?}?>	
	<input type="hidden" name="eventId" value="<?echo $_GET['id']?>">
</form>
<?}
?>

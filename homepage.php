<?
session_start();
require_once('templates/homepage.php');

require_once('templates/footer.php');
if(isset($_SESSION['username'])){?>
  <div> Logged in as <a href="profile.php"><?echo $_SESSION['username']?></a>. <a href="logout.php"> Logout </a></div>
<?
}
else{
  require_once('templates/login.php');
}

?>

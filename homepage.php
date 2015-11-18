<?
session_start();
require_once('templates/homepage.php');

require_once('templates/footer.php');
if(isset($_SESSION['username'])){?>
  <div> Logged in as <?echo $_SESSION['username']?>. <a href="logout.php"> Logout </a></div>
<?
}
else{
  require_once('templates/login.php');
}

?>

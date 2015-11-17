<?
  require_once('connect.php');
  $username = $_POST['Username'];
  $sttmt = $db->prepare('SELECT password FROM User WHERE uname=?');
  $sttmt->execute(array($username));
 $pw = $sttmt->fetch();

  if($sttmt->rowCount() !== 0 && password_verify($_POST['Password'], $pw)){
    session_start();
    $_SESSION['uname'] = $_POST['Username'];
    $_SESSION['time'] = time();
    //echo "Validei e bem!";
  }
  header('Location: ../homepage.php');
  exit();
?>

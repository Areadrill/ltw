<?
  require_once('connect.php');

  $sttmt = $db->prepare('SELECT password FROM User WHERE uname=?');
  $sttmt->execute(array($_POST['Username']));
  $pw = $sttmt->fetch();

  if($pw !== false && password_verify($_POST['Password'], $pw)){
    session_start();
    $_SESSION['uname'] = $_POST['uname'];
  }

  header('Location ../templates/login.php');
  exit();

?>

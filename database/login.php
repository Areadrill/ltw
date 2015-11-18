<?
session_start();
  require_once('connect.php');
  $username = $_POST['Username'];
  $sttmt = $db->prepare('SELECT password, salt FROM User WHERE uname=?');
  $sttmt->execute(array($username));
 $res = $sttmt->fetch();
  if($res){
    $saltedPw = $_POST['Password'].$res['salt'];
    if(hash('sha256', $saltedPw) === $res['password']){
      $_SESSION['username'] = $username;
      header('Location: ../homepage.php');
    }
  }
  //login falhou, redirecionar pra pagina d login propria
  /*header('Location: ../homepage.php');
  exit();*/
?>

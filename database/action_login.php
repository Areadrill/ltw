<?
session_start();
  require_once('connect.php');
  $username = $_POST['Username'];
  $sttmt = $db->prepare('SELECT uid, password, salt FROM User WHERE uname=?');
  $sttmt->execute(array($username));
 $res = $sttmt->fetch();
  if($res){
    $saltedPw = $_POST['Password'].$res['salt'];
    if(hash('sha256', $saltedPw) === $res['password']){
      $_SESSION['username'] = $username;
      $_SESSION['id'] = $res['uid'];
      if(isset($_POST['ajax'])){
        echo 0;
      }
      else{
          header('Location: ../homepage.php');
      }
    }
  }

  if(isset($_POST['ajax'])){
    echo "Login failed";
  }
  else{
      header('Location: ../homepage.php');
  }
  exit();
?>

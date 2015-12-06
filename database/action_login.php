<?
session_start();

  if(!isset($_POST['Username']) || !isset($_POST['Password']) || strlen($_POST['Username']) > 25){
    http_response_code(400);
    header('Location: ../index.php');
    exit();
  }

  require_once('connect.php');
  $username = strtolower($_POST['Username']);
  $sttmt = $db->prepare('SELECT uid, password, salt FROM User WHERE uname=?');
  $sttmt->execute(array($username));
 $res = $sttmt->fetch();
  if($res){
    $saltedPw = $_POST['Password'].$res['salt'];
    if(hash('sha256', $saltedPw) === $res['password']){
      $_SESSION['username'] = $username;
      $_SESSION['id'] = $res['uid'];
      $_SESSION['tok'] = bin2hex(openssl_random_pseudo_bytes(50));

      if(isset($_POST['ajax'])){
        echo 0;
      }
      else{
          header('Location: ../index.php');
      }
    }
  }

  if(isset($_POST['ajax'])){
    echo "Login failed";
  }
  else{
      header('Location: ../index.php');
  }
  exit();
?>

<?
  require_once('connect.php');

  $username = strtolower($_POST['Username']);
  $password = $_POST['Password'];
  $email = strtolower($_POST['mail']);

echo $username;

  $stmt = $db->prepare('SELECT * FROM User WHERE uname=?');
  $stmt->execute(array($username));
  $res = $stmt->fetch();
  if($res){
    header('Location: ../templates/register.php?fail=1');
    exit();
  }

  $stmt = $db->prepare('SELECT * FROM User WHERE email=?');
  $stmt->execute(array($email));
  $res1 = $stmt->fetch();
  if($res1){
    header('Location: ../templates/register.php?fail=2');
    exit();
  }

  $stmt = $db->prepare('INSERT INTO User values(null, ?, ?, ?, ?)');
  //$pw = password_hash($_POST['Password'], PASSWORD_BCRYPT); O crl do gnomo tem php 5.4 :/
  $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\][{}\'";:?.>,<!@#$%^&*()-_=+|';
  $salt = '';
  for($i = 0; $i < 100; $i++){
    $char = openssl_random_pseudo_bytes(1);
    if(strpos($charset, $char) !== FALSE){
      $salt .= $char;
    }
    else{
      if($i > 0)
        $i--;
      else $i=0;
    }
  }
  $password .= $salt;
  $passwordHashed = hash('sha256', $password);
  $stmt->execute(array($username, $passwordHashed, $salt, $email));

  header('Location: ../homepage.php');
  exit();
?>

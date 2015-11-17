<?
  require_once('connect.php');

  $stmt = $db->prepare('SELECT * FROM User WHERE uname=?');
  $stmt->execute(array($_POST['Username']));
  $res = $stmt->fetch();
  if($stmt->rowCount() !== 0){
    header('Location: ../templates/register.php?fail=1');
    exit();
  }

  $stmt = $db->prepare('SELECT * FROM User WHERE email=?');
  $stmt->execute(array($_POST['mail']));
  $res = $stmt->fetch();
  if($stmt->rowCount() !== 0){
    header('Location: ../templates/register.php?fail=2');
    exit();
  }

  $stmt = $db->prepare('INSERT INTO User values(null, ?, ?, ?)');
  $pw = password_hash($_POST['Password'], PASSWORD_BCRYPT);
  $stmt->execute(array($_POST['Username'], $pw, $_POST['mail']));

  header('Location: ../homepage.php');
  exit();
?>

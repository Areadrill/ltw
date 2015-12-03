<?session_start();
  if(!isset($_POST['comment']) || !isset($_POST['threadId'])){
    header('Location: ../homepage.php');
    exit();
  }

  require_once('connect.php');
  $stmt = $db->prepare('INSERT INTO Comment values(null, ?, ?, ?)');
  if($stmt)
    $stmt->execute(array($_SESSION['username'], $_POST['threadId'], $_POST['comment']));
  else{
    header('Location: ../homepage.php');
    exit();
  }

  echo "lel";
  //header('Location: ../thread.php?id='.$_POST['threadId']);


?>

<?session_start();
  if(!isset($_POST['comment']) || !isset($_POST['threadId']) || strlen($_POST['comment']) > 512){
    http_response_code(400);
    exit();
  }

  if(!isset($_SESSION['id'])){
    http_response_code(403);
    exit;
  }

  require_once('connect.php');
  $stmt = $db->prepare('INSERT INTO Comment values(null, ?, ?, ?)');
  $res = $stmt->execute(array($_SESSION['id'], $_POST['threadId'], $_POST['comment']));
  if(!$res){
    http_response_code(200);
    echo "hello";
    exit;
  }
  else {
    ?> <p><?echo $_POST['comment']?></p> <p class="userComment">by: <?echo $_SESSION['username']?></p><?
  }

?>

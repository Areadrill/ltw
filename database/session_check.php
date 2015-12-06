<?session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['id']) || !isset($_SESSION['tok'])){
  http_response_code(403);
  header('Location: ../homepage.php');
}

if(!isset($_POST['csrf']) || $_POST['csrf'] !== $_SESSION['tok'] ){
  http_response_code(403);
  header('Location: ../homepage.php');
}
?>

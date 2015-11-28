<?session_start();
if(!isset($_GET['id'])){
  header('Location: header.php');
  exit();
}
require_once('database/view_thread.php');
?>

<!DOCTYPE html>

<html>
  <head>
  <? require_once('templates/header.php'); ?>
  <?getThread($_GET['id']);?>
</html>

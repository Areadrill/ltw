<?session_start();
if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
  header('Location: homepage.php');
}
require_once('database/view_event.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <?require_once('templates/header.php');?>
  </head>
  <body>
    <?getEvent($_GET['id']);?>
  </body>
</html>

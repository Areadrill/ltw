<?session_start();
if (!isset($_SESSION['username'])) {
  header('Location: homepage.php');
}
require_once('database/get_Events.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <?require_once('templates/header.php');?>
    <?getEvents($_SESSION['id'])?>
  </body>
</html>

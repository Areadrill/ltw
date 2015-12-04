<?session_start();
if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
  header('Location: homepage.php');
}
require_once('database/view_event.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="stylesheets/events.css" />
    <?require_once('includes.php');?>
    <script type="text/javascript" src="scripts/eventStyle.js"></script>
    <script type="text/javascript" src="scripts/eventThreads.js"></script>

  </head>
  <body>
    <?require_once('templates/header.php');?>
    <?getEvent($_GET['id']);?>
  </body>
</html>

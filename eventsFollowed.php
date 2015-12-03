<?session_start();
require_once('database/get_events.php');?>

<!DOCTYPE html>
<html>
  <head>
    <?require_once('includes.php');?>
  </head>
  <body>
    <?require_once('templates/header.php');?>
    <?getEventsUserFollows($_SESSION['id'])?>
  </body>
</html>

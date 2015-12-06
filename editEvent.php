<?session_start();
if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
  header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/editEvent.css" >
    <?require_once('includes.php');?>
    <script type="text/javascript" src="scripts/editEventValidations.js" ></script>
  </head>
  <body>
    <?require_once('templates/header.php');?>
    <?require_once('templates/editEvent.php');?>
  </body>
</html>

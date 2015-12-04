<?session_start();
if(!isset($_SESSION['username'])){
  header('Location: homepage.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="stylesheets/editEvent.css" >
    <?require_once('includes.php');?>
    <script type="text/javascript" src="scripts/createEventValidations.js" ></script>
  </head>
  <body>
    <?require_once('templates/header.php');?>
    <?require_once('templates/createEvent.php');?>
  </body>
</html>

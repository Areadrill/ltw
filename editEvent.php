<?session_start();
if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
  header('Location: homepage.php');
}
//falta verificar se o user q ta aqui e o owner deste evento
?>
<!DOCTYPE html>
<html>
  <head>
    <?require_once('includes.php');?>
    <script type="text/javascript" src="scripts/editEventValidations.js" ></script>
  </head>
  <body>
    <?require_once('templates/header.php');?>
    <?require_once('templates/editEvent.php');?>
  </body>
</html>

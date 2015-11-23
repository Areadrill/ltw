<?session_start();
if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
  header('Location: homepage.php');
}
//falta verificar se o user q ta aqui e o owner deste evento
?>
<!DOCTYPE html>
<html>
  <head>
    <?require_once('templates/header.php');?>
  </head>
  <body>
    <?require_once('templates/editEvent.php');?>
  </body>
</html>

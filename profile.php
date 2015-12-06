<?session_start();
if(!isset($_SESSION['username']))
  header('Location: homepage.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <?require_once('includes.php');?>
  </head>
  <body>
    <?require_once('templates/header.php');?>
    <?require_once('templates/profile.php');?>
  </body>
</html>

<?session_start();
if(!isset($_SESSION['username']) || !isset($_GET['id'])){
  header('Location: homepage.php');
}
require_once('database/get_users.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <?require_once('includes.php');?>
  </head>
  <body>
    <?require_once('templates/header.php');?>
    <?if(!isset($_POST['searchString']))
        getUsersByName('');
      else{
        getUsersByName($_POST['searchString']);
      }?>
  </body>
</html>

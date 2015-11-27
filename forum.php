<?
session_start();
if(!isset($_GET['id'])){
  header('Location: homepage.php');
}
require_once('database/get_forum.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <?require_once('templates/header.php');?>
    <?getEventThreads($_GET['id']);?>
  </body>
</html>

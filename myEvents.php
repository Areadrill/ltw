<?
session_start();
if(!isset($_SESSION['username']))
  header('Location: index.php');

 require_once('database/get_events.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <?require_once('includes.php');?>
    <link rel="stylesheet" type="text/css" href="stylesheets/myEvents.css" >
  </head>
  <body>
    <?require_once('templates/header.php');?>
  <?getEvents($_SESSION['id']);?>
</body>
</html>

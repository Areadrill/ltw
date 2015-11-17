<!DOCTYPE html>
<html>
<head>
<?
require_once('header.php');
?>
<script type="text/javascript" src="../js/validations.js"></script>
</head>
<body>
<form id=register action="../database/register.php" method="post">
  <label>Username:
    <input id="uname" type="text" name="Username">
  </label>
</br>
  <label>Password:
    <input id="pass" type="password" name="Password">
  </label>
</br>
  <label>Re-type password:
    <input id="repass" type="password" name="Rep-pass" >
  </label>
</br>
  <label>E-mail:
    <input id="mail" type="text" name="mail">
  </label>
</br>
  <input type="submit" value="Register" >

</form>
<? require_once('footer.php'); ?>

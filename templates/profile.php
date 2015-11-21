<?session_start();
if(!isset($_SESSION['username']))
  header('Location: homepage.php');
?>
<p>Profile for: <?echo $_SESSION['username'];?>
<section id="links" >
  <ul>
    <li> <a href="createEvent.php">Create new event</a> </li>
    <li> <a href="myEvents.php"> View my events </a></li>
    <li> Account options </li>
  </ul>
</section>

<section id="feed" >
  <!-- n sei se isto n sera meter-mo-nos por caminhos apertados -->
</section>

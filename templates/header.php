
  <section id="header">
    <a href="homepage.php"><img src="images/site/logoSmallestCropped.png" /></a>
    <section id="login">
      <? if(isset($_SESSION['username'])){?>
        <div id="logged"> Logged in as <a href="profile.php"><?echo $_SESSION['username']?></a>. <a href="logout.php"> Logout </a></div>
        <?
      }
      else{
        require_once('templates/login.php');
      }?>
    </section>
    <?//outro ficheiro? passar isto a javasript para dar resultados imediatos (a la google)? tb da pra fazer os 2...?>
    <form id="search" action="searchEvents.php" method="get" >
      
      <input type="text" name="searchWords" maxlength="25" placeholder="Search for events here">
      <input id="searchEvent" type="submit" value="Search" >
    </form>
    <? if(isset($_SESSION["username"])){?>

      <ul id="options">
        <li> <a href="createEvent.php">New event</a> </li>
        <li> <a href="myEvents.php"> My events </a></li>
        <li> <a href="eventsFollowed.php"> Following </a></li>
      </ul>

    <?}?>

  </section>

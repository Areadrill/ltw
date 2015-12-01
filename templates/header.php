<title> Eventager </title>
<link rel="stylesheet" type="text/css" href="stylesheets/header.css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>
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
      <input type="submit" value="Search" >
    </form>

  </section>

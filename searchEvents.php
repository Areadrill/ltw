<?
session_start();
if(!isset($_SESSION['username']))
  header('Location: homepage.php');

 require_once('database/get_events.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <?require_once('includes.php');?>
  </head>
  <body>
    <?require_once('templates/header.php');?>
    <p>Search by type:</p>
    <form action="searchEvents.php" method="get">
      <label>Type of event
        <select id="type" name="eventType">
          <option>Concert</option>
          <option>Music Festival</option>
          <option>Movie Showing</option>
          <option>Movie Marathon</option>
          <option>Flash Mob</option>
          <option>Convention</option>
          <option>Conference</option>
          <option>Fundraiser</option>
          <option>...</option>
        </select>
      </label>

      <input type="submit" value="Search" >
    </form>

  <?if(isset($_GET['searchWords'])){
    getEventsByName($_GET['searchWords']);
  }
  else if(isset($_GET['eventType'])){
    getEventsByType($_GET['eventType']);
  }?>
</body>
</html>

<?session_start();
if(!isset($_SESSION['username']))
  header('Location: homepage.php');
?>

<form action="database/action_createEvent.php" method="post" enctype="multipart/form-data">
  <label>Event name:
    <input id="eventName" type="text" name="eventName" maxlength="25">
  </label>
</br>
  <label>Date
    <input id="eventDate" type="date" name="eventDate" >
  </label>
</br>
<label>Description:</br>
  <textarea rows="8" cols="80" maxlength="1000" name="eventDescription"></textarea>
</label>
</br>
<label>Type of event
  <select id="type" name="eventType"> <!--Guardar as opçoes em JSON e usar javascript pra fazer load?-->
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
</br>
  <label>The event is:</br>
    <input id="eventShowing0" type="radio" name="eventShowing" value="0">Public (will appear in searches and be visible by everyone) </br>
    <input id="eventShowing0" type="radio" name="eventShowing" value="1">Private (will NOT appear in searches and users must be invited to be able to follow) </br>
  </label>

  <label> Image for the event (you will be able to add more later)</br>

    <input id="eventImage" type="file" name="eventImage">
  </label>

  <p> Note: All of these options will be editable after the event is created. </p>

  <input type="submit" value="Create" >
</form>

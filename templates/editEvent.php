<?$db = new PDO('sqlite:database/db/EventagerDB.db');
  $stmt = $db->prepare('SELECT * FROM Event WHERE eid=?');
  $stmt->execute(array($_GET['id']));
  $eventInfo = $stmt->fetch();
?>
<form action="database/action_editEvent.php" method="post">
  <label>Event name:
    <input id="eventName" type="text" name="eventName" maxlength="25" value="<?echo $eventInfo['ename']?>">
  </label>
</br>
  <label>Date
    <input id="eventDate" type="date" name="eventDate" value="<?echo $eventInfo['edate']?>">
  </label>
</br>
<label>Description:</br>
  <textarea rows="8" cols="80" maxlength="1000" name="eventDescription"><?echo $eventInfo['description']?></textarea>
</label>
</br>
<label>Type of event
  <select id="type" name="eventType" value="<?echo $eventInfo['type']?>"> <!--Guardar as opçoes em JSON e usar javascript pra fazer load?-->
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

  <label> Image for the event (Leave this blank if you want to keep the image the event has currently)</br>

    <input id="eventImage" type="file" name="eventImage">
  </label>
  <?$_POST['eventId'] = $_GET['id']?>
</br>
  <input type="submit" value="Save Changes" >
</form>

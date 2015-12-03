<?$db = new PDO('sqlite:database/db/EventagerDB.db');
  $stmt = $db->prepare('SELECT * FROM Event WHERE eid=?');
  $stmt->execute(array($_GET['id']));
  $eventInfo = $stmt->fetch();
?>
<form id="editEvent" action="database/action_editEvent.php" method="post" enctype="multipart/form-data">
  <label>Event name:
    <input id="eventName" type="text" name="eventName" maxlength="25" value="<?echo $eventInfo['ename']?>">
  </label>
</br>
  <label>Date
    <input id="eventDate" type="date" name="eventDate" value="<?echo $eventInfo['edate']?>">
  </label>
</br>
<label>Description:</br>
  <textarea id="eventDescription" rows="8" cols="80" maxlength="1000" name="eventDescription"><?echo $eventInfo['description']?></textarea>
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
    <?if($eventInfo['private'] == 0){?>
    <input id="eventShowing0" type="radio" name="eventShowing" value="0" checked>Public (will appear in searches and be visible by everyone) </br>
    <input id="eventShowing0" type="radio" name="eventShowing" value="1">Private (will NOT appear in searches and users must be invited to be able to follow) </br>
    <?}
    else if($eventInfo['private'] == 1){?>
      <input id="eventShowing0" type="radio" name="eventShowing" value="0">Public (will appear in searches and be visible by everyone) </br>
      <input id="eventShowing0" type="radio" name="eventShowing" value="1" checked>Private (will NOT appear in searches and users must be invited to be able to follow) </br>
    <?}?>
  </label>

  <label> Image for the event (Leave this blank if you want to keep the image the event has currently)</br>

      <input id="eventImage" type="file" name="eventImage">
  </label>

  <input type="hidden" name="eventId" value="<?echo $eventInfo['eid']?>">
</br>
  <input type="submit" value="Save Changes" >
</form>

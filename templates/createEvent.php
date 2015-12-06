<div class="header"><h1>Creating Event</h1>
<span> Please fill out the form below.</span>
</div>
<form id="createEvent" action="database/action_createEvent.php" method="post" enctype="multipart/form-data">
  <label>Event name:
    <input id="eventName" type="text" name="eventName" maxlength="25">
  </label>
</br>
  <label>Date
    <input id="eventDate" type="date" name="eventDate" >
  </label>
</br>
<label>Description:</br>
  <textarea id="eventDescription" rows="8" cols="80" maxlength="1000" name="eventDescription"></textarea>
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
</label>
</br>
  <label>The event is:</br>
    <input id="eventShowing0" type="radio" name="eventShowing" value="0" checked>Public  </br>
    <input id="eventShowing1" type="radio" name="eventShowing" value="1">Private</br>
  </label>

  <label> Image for the event (you will be able to add more later)</br>
      </br>
    <input id="eventImage" type="file" name="eventImage">
  </label>

  <p> Note: All of these options will be editable after the event is created. </p>

  <input type="submit" id="submit" value="Create" >
</form>

<?if(isset($_GET['fail'])){?>
  <p id="failmsg">The event could not be created at this time, please check if the name is unique.</p>
<?}?>

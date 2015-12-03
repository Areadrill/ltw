

<form id="createThread" action="database/action_createThread.php" method="post" enctype="multipart/form-data">
  <label>Thread title:
    <input id="threadTitle" type="text" name="threadTitle" maxlength="50">
  </label>
</br>
<label>Text:</br>
  <textarea id="threadText" rows="8" cols="80" maxlength="1000" name="threadText"></textarea>
</label>
<input type="hidden" name="eventId" value="<?echo $_POST['eventId']?>"
</br>
  <input type="submit" value="Create" >
</form>

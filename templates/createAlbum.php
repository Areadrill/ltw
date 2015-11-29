<form id="createAlbum" action="database/action_createAlbum.php" method="post">
  <label>Event Number:
    <input type="number" name="eventId" min="0"/>
  </label>
  <label>Album Name:
    <input type="file" name="albumName"/>
  </label>
  <input type="submit" hidden="hidden">
</form>

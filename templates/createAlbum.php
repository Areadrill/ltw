<form id="createAlbum" action="database/action_createAlbum.php" method="post">
  <label>Event Number:
    <input type="number" name="eventId" min="0"/>
  </label>
  <label>Album Name:
    <input type="text" name="albumName"/>
  </label>
  <input type="submit">
  <input type="hidden" name="csrf" value="<?echo $_SESSION['tok']?>" />
</form>

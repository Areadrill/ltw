<form id="uploadAlbumImage" enctype="multipart/form-data" action="database/action_uploadAlbumImage.php" method="post">
  <label>Album Number:
    <input type="number" name="albumId" min="0"/>
  </label>
  <label>Image File:
    <input type="file" name="albumImage" id="albumImage"/>
  </label>
  <input type="submit">
</form>

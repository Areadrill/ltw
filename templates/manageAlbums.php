<ul>
  <li><?require("templates/createAlbum.php");?></li>
  <?
    require_once("database/album.php");
    $albums = getAlbums($_GET["eid"]);
    foreach($albums as $album){
      ?>
      <li data-aid="<?echo $album["aid"]?>">
        <?require("templates/uploadAlbumImage.php");?>
      </li>
    <?
    }
  ?>

</ul>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="../scripts/manageAlbums.js"></script>

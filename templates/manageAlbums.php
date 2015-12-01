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
<script type="text/javascript" src="manageAlbums.js"></script>

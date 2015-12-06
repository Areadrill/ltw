<?session_start();
if(!isset($_GET["id"])){
  http_response_code(400);
  exit();
}

require_once("album.php");
$owners = getAlbumAllowedEditors($_GET["id"]);

if(!isset($_SESSION["id"]) || !in_array($_SESSION["id"], $owners, TRUE)){
  http_response_code(403);
  exit();
}

if(!existsAlbum($_GET["id"])){
  http_response_code(404);
  exit();
}
$album = getAlbum($_GET["id"]);

$deleted = deleteAlbum($_GET["id"]);
var_dump($deleted);
if(!$deleted){
  http_response_code(500);
  exit;
}
http_response_code(200);

header("Location: ../event.php?id=".$album["eid"]);
?>

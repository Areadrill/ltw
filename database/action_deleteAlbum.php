<?session_start();
if(!isset($_GET["id"])){
  http_response_code(422);
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

$deleted = deleteAlbum($_GET["id"]);
if(!$deleted){
  http_response_code(500);
  exit;
}
http_response_code(200);
?>

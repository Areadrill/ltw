<?session_start();
if(!isset($_POST["aid"]) || !isset($_POST["iid"])){
  http_response_code(400);
  exit();
}

require_once("album.php");
$owners = getAlbumAllowedEditors($_POST["aid"]);
$album = getAlbum($_POST["aid"]);
if(!isset($_SESSION["id"]) || !in_array($_SESSION["id"], $owners, TRUE) ){
  http_response_code(403);
  exit();
}

if(!existsAlbum($_POST["aid"])|| !imageInAlbum($_POST["iid"], $_POST["aid"])){
  http_response_code(404);
  exit();
}

require("connect.php");
$stmt2 = $db->prepare("DELETE FROM ImageAlbum WHERE iid=? and aid=?");
$res2 = $stmt2->execute(array($_POST["iid"], $_POST["aid"]));
$stmt = $db->prepare('DELETE FROM Image WHERE iid=?');
$res = $stmt->execute(array($_POST["iid"]));

if(!$res || !$res2){
  http_response_code(500);
  var_dump($_POST["iid"]);
  exit;
}
http_response_code(200);
?>

<?
require_once("album.php");
require_once('session_check.php');
$albumName = $_POST["albumName"];
$eventId = $_POST["eventId"];

require_once("connect.php");
$stmt = $db->prepare("SELECT uid FROM EventOwner WHERE eid=?");
$stmt->execute(array($eventId));
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$allowed = FALSE;

foreach($results as $result){
  if($result["uid"] == $_SESSION["id"])
    $allowed = TRUE;
}



if($allowed){
  $result = createAlbum( $eventId, $albumName);
  if($result == FALSE){
    http_response_code(500);
  }
}
else
http_response_code(200);

?>

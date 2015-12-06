<?
require_once('session_check.php');
require_once('connect.php');
$statmt = $db->prepare("SELECT uid FROM EventOwner WHERE eid=?");
$statmt->execute(array($_GET['id']));
$uid_results = $statmt->fetchAll();

foreach($uid_results as $result){
  if($_SESSION['id'] == $result['uid']){
    $delete_sttmt = $db->prepare("DELETE FROM Event WHERE eid=?");
    $result = $delete_sttmt->execute(array($_GET['id']));
    header("Location: ../myEvents.php");
  }
}
header("Location: ../index.php");

?>

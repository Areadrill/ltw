<?
require_once("album.php");
require_once('session_check.php');
if(!isset($_POST["aid"]) || !isset($_POST["newName"])){
  http_response_code(400);
  exit;
}

if(strlen($_POST['newName']) == 0 || strlen($_POST['newName']) > 50){
  http_response_code(400);
  exit();
}

if(!isset($_SESSION["id"])){
  http_response_code(401);
  exit;
}

if(!in_array($_SESSION["id"], getAlbumAllowedEditors($_POST["aid"]))){
  http_response_code(403);
  exit;
}

if(!existsAlbum($_POST["aid"])){
  http_response_code(404);
  exit();
}

$res = renameAlbum($_POST["aid"], $_POST["newName"]);

if(!$res)
{
  http_response_code(500);
  exit;
}

$album = getAlbum($_POST["aid"]);

echo json_encode($album["nome"]);

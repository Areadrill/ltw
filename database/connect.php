
<?
if(!defined('PUBLIC_PATH')){
define('PUBLIC_PATH',dirname(realpath(__FILE__)) . "/");
define('BASE_PATH',dirname(PUBLIC_PATH));
}

$db = new PDO('sqlite:' . BASE_PATH . '/database/db/EventagerDB.db');

 $db->exec( 'PRAGMA foreign_keys = ON;' );
?>

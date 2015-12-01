<?
 $db = new PDO("sqlite:". $_SERVER["DOCUMENT_ROOT"] . '/database/db/EventagerDB.db');
 $db->exec( 'PRAGMA foreign_keys = ON;' );
?>

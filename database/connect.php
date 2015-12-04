<?

  //$_SERVER['DOCUMENT_ROOT'] = '/usr/users2/mieec2013/up201303462/public_html/proj';
 $db = new PDO("sqlite:". $_SERVER['DOCUMENT_ROOT'] . '/database/db/EventagerDB.db');
 $db->exec( 'PRAGMA foreign_keys = ON;' );
?>



<!DOCTYPE html>
<html lang="en">

  <head>
    <title>MyCMS</title>
  </head>

  <body>
	<?php

	  include_once('myCMS.php');
	  $obj = new myCMS();
	  $obj->host = '127.0.0.1';
	  $obj->username = 'root@localhost';
	  $obj->password = '';
	  $obj->db = 'test';
	  $obj->connect();

	  if ( $_POST )
		$obj->write($_POST);

	  echo ( $_GET['admin'] == 1 ) ? $obj->display_admin() : $obj->display_public();

	?>
  </body>

</html>
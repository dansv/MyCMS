

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>MyCMS</title>
  </head>

  <body>
	<?php
		
		include_once('myCMS.php');
		include_once('../db_connect.php');
		$obj = new myCMS();
		
		$obj->host = $host;
		$obj->username = $username;
		$obj->password = $password;
		$obj->db = $db;
		$obj->connect();

		if ( $_POST )
			$obj->write($_POST);

		echo $obj->display_public();

	?>
  </body>

</html>
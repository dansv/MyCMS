<!DOCTYPE html>
<html lang="en">
<!-- design idea http://fc05.deviantart.net/fs71/i/2012/211/7/f/portfolio_layout_design_1_by_adele_waldrom-d596131.jpg -->
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

		echo $obj->display_public("1");

	?>
  </body>

</html>
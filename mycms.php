<?php
//initial idea credited to Jason Lengstorf at http://css-tricks.com/
class myCMS{
	var $host;
	var $username;
	var $password;
	var $db;
	
	public function display_public(){
		$q = "SELECT * FROM cmsdb ORDER BY created DESC LIMIT 3";
		$r = mysql_query($q);
		$entry_display = "";
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			while ( $a = mysql_fetch_assoc($r) ) {
				$title = stripslashes($a['titel']);
				$bodytext = stripslashes($a['bodytext']);

				$entry_display .= <<<ENTRY_DISPLAY

				<h2>$title</h2>
				<p>
				  $bodytext
				</p>
ENTRY_DISPLAY;
			}
		} else {
			$entry_display = <<<ENTRY_DISPLAY

			<h2>This Page Is Under Construction</h2>
			<p>
			  No entries have been made on this page. 
			  Please check back soon, or click the
			  link below to add an entry!
			</p>
ENTRY_DISPLAY;
		}
		return $entry_display;
	}
	
	public function display_admin() {
		$str = $_SERVER['PHP_SELF'] . "?admin=0";
		return <<<ADMIN_FORM

		<form action="{$str}" method="post">
		  <label for="title">Title:</label>
		  <input name="title" id="title" type="text" maxlength="150" />
		  <label for="bodytext">Body Text:</label>
		  <textarea name="bodytext" id="bodytext"></textarea>
		  <input type="submit" value="Create This Entry!" />
		</form>
ADMIN_FORM;

	}
	
	public function write($p){
		if ( $p['title'] )
		  $title = mysql_real_escape_string($p['title']);
		if ( $p['bodytext'])
		  $bodytext = mysql_real_escape_string($p['bodytext']);
		if ( $title && $bodytext ) {
		  $created = time();
		  $sql = "INSERT INTO cmsdb VALUES('$title','$bodytext','$created')";
		  return mysql_query($sql);
		} else {
		  return false;
		}
	}
	
	public function connect() {
		mysql_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysql_error());
		mysql_select_db($this->db) or die("Could not select database. " . mysql_error());

		return $this->buildDBtable();
	}
}	
?>
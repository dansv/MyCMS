<?php
//initial idea credited to Jason Lengstorf at http://css-tricks.com/
//TODO: implement prepared statements and parametrized queries http://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php
class myCMS{
	var $host;
	var $username;
	var $password;
	var $db;
	
	public function display_public($type){
		if($type=="1"){
			$q = "SELECT * FROM cmsdb WHERE Type='1' ORDER BY created DESC LIMIT 3";
		}
		else{
			$q = "SELECT * FROM cmsdb WHERE Type='0' ORDER BY created DESC LIMIT 3";
		}
		$r = mysql_query($q);
		$entry_display = "";
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			while ( $a = mysql_fetch_assoc($r) ) {
				$title = stripslashes($a['titel']);
				$bodytext = stripslashes($a['bodytext']);
				$the_image = stripslashes($a['Image']);
				$the_link = stripslashes($a['Link']);
				$github = stripslashes($a['Github']);
				
				$entry_display .= <<<ENTRY_DISPLAY

				<h2>$title</h2>
				<p>
					$bodytext
				</p>
				<div class="entry_html">
					<img src="$the_image" alt="presentation img" />
				</div>
				<div class="entry_links">
					<a href="$github" >$github</a> <a href="$the_link">$the_link</a>
				</div>
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
		$str = $_SERVER['PHP_SELF'];
		return <<<ADMIN_FORM

		<form action="{$str}" method="post">
		  <label for="title">Title:</label>
		  <input name="title" id="title" type="text" maxlength="150" />
		  <label for="bodytext">Body Text:</label>
		  <textarea name="bodytext" id="bodytext"></textarea>
		  <label for="the_image">Image for presentation:</label>
		  <input type="text" maxlength="150" name="the_image" id="the_image" />
		  <label for="github">Github:</label>
		  <input name="github" id="github" type="text" maxlength="150" />
		  <label for="the_link">link to the project:</label>
		  <input name="the_link" id="the_link" type="text" maxlength="150" />
		  <label for="the_type">Sandbox(0) or school(1):</label>
		  <input name="the_type" id="the_type" type="text" maxlength="5" />
		  <input type="submit" value="Create This Entry!" />
		</form>
ADMIN_FORM;

	}
	
	public function write($p){
		if ( $p['title'] )
			$title = mysql_real_escape_string($p['title']);
		if ( $p['bodytext'])
			$bodytext = mysql_real_escape_string($p['bodytext']);
		if ( $p['the_image'])
			$the_image = mysql_real_escape_string($p['the_image']);
		if ( $p['github'])
			$github = mysql_real_escape_string($p['github']);
		if ( $p['the_link'])
			$the_link = mysql_real_escape_string($p['the_link']);
		if ( $p['the_type'])
			$the_type = mysql_real_escape_string($p['the_type']);
		  
		if ( $title && $bodytext && $the_image && $github && $the_link && $the_type ) {
			  $created = time();
			  $sql = "INSERT INTO cmsdb (titel, bodytext, created, Image, Github, Link, Type) VALUES('$title','$bodytext','$created','$the_image','$github','$the_link','$the_type')";
			  return mysql_query($sql) or die("Error: ".mysql_error());;
		} else {
			return false;
		}
	}
	
	public function connect() {
		mysql_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysql_error());
		mysql_select_db($this->db) or die("Could not select database. " . mysql_error());

		return true;
	}
}	
?>
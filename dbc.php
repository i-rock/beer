<?php

$server = "localhost";
$username = "irockefeller";
$password = "";
$database = "test";

if (!mysql_connect($server, $username, $password)) {
  echo "<p>Could not connect to 	server with username '$username'.</p>";
	
//  mysql_select_db: Sets the current active database on the server that's associated 
//    with the specified link identifier. Every subsequent call to mysql_query() 
//    will be made on the active database.
//  Returns TRUE on success or FALSE on failure.
} elseif (!mysql_select_db($database)) {
  echo "<p>Could not connect to 	database '$database'.</p>";
  
} 

?>
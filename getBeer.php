<?php
require_once("dbc.php");

if (isset($_GET['id'])) {
	$id=$_GET['id'];

	$query = "select score from beer where beer_id='$id'";
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	
	if(!is_int($row['score'])) {
		$query = "insert into beer (beer_id) values ('$id')";
		mysql_query($query);
		echo '0';
	} else {
		echo $row['score'];
	}

} else {
	echo 'get id not set';
}

?>
<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$row = NULL;
	$sql = "SELECT * FROM `clubs`";
	$result = mysqli_query($con, $sql);
	$row = NULL;
	$resultArr = array();
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$resultArr[] = $row;
	}
	echo json_encode($resultArr);
?>
<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";

	$con=mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (mysqli_connect_errno())
 	{
 		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}

	$clubid = $_POST['clubid'];

  	$sql = "SELECT `userid` FROM `memberships` WHERE `clubid` = $clubid";
	$result=mysqli_query($con,$sql);

	if (mysqli_num_rows($result) > 0) {
    	while($row = mysqli_fetch_assoc($result)) {
    		$studentid = $row["userid"];
    		$sql2 = "SELECT `firstname`,`lastname`,`email`,`grade` FROM `users` WHERE `id` = $studentid";
    		$result2 = mysqli_query($con,$sql2);
			if (mysqli_num_rows($result2) > 0) {
    			while($row2 = mysqli_fetch_assoc($result2)) {
    				echo "firstName:". $row2["firstname"]. ",lastName:". $row2["lastname"]. ",email:". $row2["email"]. ",grade:". $row2["grade"]. ",";
    			}
    		}
    	}
    } else {
    	echo "0 results";
	}

	$con->close();
	
?>
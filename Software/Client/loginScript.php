<?php 
session_start();
// Database configuration
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "root";
$dbName  = "rakusen";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (isset($_POST['loginSubmit']) ){

if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: register-page.php?error=User Name is required");
	    exit();
	}else if(empty($pass)){
        header("Location: register-page.php?error=Password is required");
	    exit();
	}else{
		// hashing the password
        $hashed_pass = md5($pass);
		
		
        
		$sql = "SELECT * FROM users WHERE uname='$uname'";

		

		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['uname'] === $uname) {
            	$_SESSION['uname'] = $row['uname'];
            	$_SESSION['fname'] = $row['fname'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: landingpages.php");
		        exit();
            }else{
				header("Location: register-page.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location: register-page.php?error=Incorect User name or password");
	        exit();
		}
	}
	
}else{
	header("Location: index.php");
	exit();
}

}
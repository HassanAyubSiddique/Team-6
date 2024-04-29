<?php
include "dbConfig.php";


if(isset($_POST['registerSubmit']) ){

if (isset($_POST['fname']) 
&& isset($_POST['uname'])
&& isset($_POST['email']) 
&& isset($_POST['phone'])
&& isset($_POST['address'])
&& isset($_POST['city'])
&& isset($_POST['password'])
&& isset($_POST['re_password']) 
&& isset($_POST['postcode'])
&& isset($_POST['country']) 
) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$fname = validate($_POST['fname']);
	$uname = validate($_POST['uname']);
	$email = validate($_POST['email']);
	$phone = validate($_POST['phone']);
    $address = validate($_POST['address']);
	$city = validate($_POST['city']);

	$password = validate($_POST['password']);
	$re_password = validate($_POST['re_password']);

    $postcode = validate($_POST['postcode']);
	$country = validate($_POST['country']);

	$user_data = 'uname='. $uname. '&fname='. $fname;


	if (empty($fname)) {
		header("Location: register-page?error=Full Name is required&$user_data");
	    exit();
	}else if(empty($uname)){
        header("Location: register-page?error=User Name is required&$user_data");
	    exit();
	}
	else if(empty($email)){
        header("Location: register-page?error=email is required&$user_data");
	    exit();
	} 

	else if(empty($phone)){
        header("Location: register-page?error=phone is required&$user_data");
	    exit();
	}

    else if(empty($address)){
        header("Location: register-page?error=address is required&$user_data");
	    exit();
	}

    else if(empty($city)){
        header("Location: register-page?error=city is required&$user_data");
	    exit();
	}

    else if(empty($postcode)){
        header("Location: register-page?error=postcode is required&$user_data");
	    exit();
	}

    else if(empty($country)){
        header("Location: register-page?error=country is required&$user_data");
	    exit();
	}

	else if($password !== $re_password){
        header("Location: register-page?error=The confirmation password  does not match&$user_data");
	    exit();
	}

	else{

		// hashing the password
        $pass = md5($password);

	    $sql = "SELECT * FROM users WHERE uname='$uname' ";
		$result = mysqli_query($db, $sql);

		if (mysqli_num_rows($result) > 0) {
			header("Location: register-page.php?error=The username is taken try another&$user_data");
	        exit();
		}else {
           $sql2 = "INSERT INTO users(fname, uname, email, phone, address, city, password, postcode, country) VALUES('$fname', '$uname', '$email', '$phone', '$address', '$city', '$pass', '$postcode', '$country')";
           $result2 = mysqli_query($db, $sql2);
           if ($result2) {
           	 header("Location: register-page.php?success=Your account has been created successfully");
	         exit();
           }else {
	           	header("Location: register-page.php?error=unknown error occurred&$user_data");
		        exit();
           }
		}
	}
	
}else{
	header("Location: register-page.php");
	exit();
}

}

?>
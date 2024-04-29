<?php
require_once 'cart.php';

if(!isset($_SESSION['uname'])){

    
header('Location: register-page.php');

}else{
  $loged_uname = $_SESSION['uname'];
}

if(isset($_POST["updateUserInfo"])){



	$fname = $_POST['fname'];
	$uname = $_POST['uname'];
	$phone = $_POST['phone'];
    $address = $_POST['address'];

    $city = $_POST['city'];
	$country = $_POST['country'];
	$postcode = $_POST['postcode'];
  
	

            $update = $db->query("UPDATE users SET fname = '$fname', uname = '$uname', phone = '$phone' , address = '$address' , city = '$city', country = '$country', postcode = '$postcode' WHERE uname = '$loged_uname'");
            
			if($update){
                header("Location: logout.php");
            }else{
                header("Location: AdProfile.php?success=Your account update was not successful");

            } 
      

        }


        if(isset($_POST["updateUserPassword"])){



            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];


            if($newPassword !== $confirmPassword){
                header("Location: AdProfile.php?success=Password does not match");
                die();
            }
       

            $sql = "SELECT * FROM users WHERE uname='$loged_uname'";

		

		$result = mysqli_query($db, $sql);

			$row = mysqli_fetch_assoc($result);
            if ($row['uname'] === $uname) {
            	$_SESSION['uname'] = $row['uname'];
          
            
        
                    $update = $db->query("UPDATE users SET fname = '$fname', uname = '$uname', phone = '$phone' , address = '$address' , city = '$city', country = '$country', postcode = '$postcode' WHERE uname = '$loged_uname'");
                    
                    if($update){
                        header("Location: logout.php");
                    }else{
                        header("Location: AdProfile.php?success=Your account update was successful");
        
                    } 
              
        
                }
            }
?>
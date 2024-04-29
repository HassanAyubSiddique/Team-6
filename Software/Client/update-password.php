<?php


require_once 'cart.php';

if(!isset($_SESSION['uname'])){

    
header('Location: register-page.php');

}


$loged_uname = $_SESSION['uname'];




if(isset($_POST["updateUserPassword"])){

              

                $oldPassword = $_POST['oldPassword'];
                $newPassword = $_POST['newPassword'];
                $confirmPassword = $_POST['confirmPassword'];

                
            var_dump(333);

                if($newPassword != $confirmPassword){
                    header("Location: AdProfile.php?error=Password does not match");
                    die();
                   
                } else{
                 
                
           

                $password = md5($confirmPassword);

                echo $passwword;
    
                
    
                $sql = "SELECT * FROM users WHERE uname='$loged_uname' AND password='$password'";

                
                if($sql) {
    
                
            $result = mysqli_query($db, $sql);
    
                $row = mysqli_fetch_assoc($result);
                    


                        $update = $db->query("UPDATE users SET password = '$password' WHERE uname = '$loged_uname'");
                        
                        if($update){
                            header("Location: logout.php");
                        }else{
                            header("Location: AdProfile.php?success=Your account update was not successful");
                            die();
                        } 
                  
            
                    } else{
                        header("Location: AdProfile.php?success=User name or password does not match");
                        die();
                    }
                }
    
    

            }




?>
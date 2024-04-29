<?php
require_once 'cart.php';

if(!isset($_SESSION['uname'])){

    
header('Location: register-page.php');

}else{
  $logged_in_user = $_SESSION['uname'];
}



$id = $_GET['id'];

$qry = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($db, $qry);
$fetch = mysqli_fetch_array($result);

$qry1 = "SELECT * FROM users WHERE uname = '$logged_in_user'";
$result1 = mysqli_query($db, $qry1);
$fetch1 = mysqli_fetch_array($result1);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Cart page</title>
    <link rel="stylesheet" href="VendorCss/style.css">    <!-- link css -->
    <style>
        button#add_to_cart{
            background-color: #088178 !important;
                color: #fff !important;
                font-size: 1.2rem !important;
                font-weight: bold !important;
                padding: 10px 20px !important;
                border-radius: 5px !important;
                box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2) !important;
                transition: all 0.3s ease !important;
    
        }
    </style>
</head>
<body>
    <!-- this is for the nav bar of the page -->
    <section id="header">
        <a href="landingpages.php"> <img src="img/Screenshot 2024-03-16 at 01.50.29.png" class="logo" al t=""></a>
        <div>
            <ul id="navbar">
                <li>
                    <div class="search-container">
                        <input type="text" placeholder="Search..." class="search-bar">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </li>
                
                <li><a class="active" href="landingpages.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="cart-page.php"><i class="fa-solid fa-cart-shopping"></i> 
                            <?php if(empty($count)){ ?>
                            <span> 0  </span>
                            <?php }else{ ?>
                            <span> <?= $count ?>  </span>
                            <?php } ?>
                     </a>
                </li>

            
             

                <img src="img/user1.png"  class="user-pro" onclick="toggleMenu()">    

                <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">

                <?php if(isset($_SESSION['uname'])){ ?>
                      <!-- User profile details -->
                    <div class="user-info">
                        <img src="img/user1.png" >
                        <h3><?= $_SESSION['uname'] ?></h3>
                    </div>
                    <hr>
                        <!-- Sub-menu links -->      <!-- add the  links  here -->
                    <a href="AdProfile.php" class="sub-menu-link">
                        <i class="fas fa-user"></i>
                        <p>Profile</p>
                        <span>></span>
                    </a>
                       <!-- Sub-menu links -->      <!-- add the  links  here -->       <!-- just add the register page link here -->  
                    <a href="logout.php" class="sub-menu-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                        <span>></span>
                    </a>


                    <?php } else{?>

                        <div class="user-info">
                        <img src="img/user1.png" >
                        <h3>Join us</h3>
                    </div>
                    <hr>
                        <!-- Sub-menu links -->      <!-- add the  links  here -->
                    <a href="register-page.php" class="sub-menu-link">
                        <i class="fas fa-user"></i>
                        <p>Sign in</p>
                        <span>></span>
                    </a>

                    <?php } ?>


                </div>
            </div>
            </ul>
        </div>
     </section>
     <section id="prodetail" class="section-p1">
        <div class="single-prot-img">
            <img src="uploads/<?= $fetch['main_photo'] ?>" width="100%" id="MainImg" alt="">
    
            
            <div class="related-imgs-group">
                <div class="related-img-col">
                    <img src="uploads/<?= $fetch['photo_one'] ?>" width="100%" class="related-img" alt="">
                </div>
                <div class="related-img-col">
                    <img src="uploads/<?= $fetch['photo_two'] ?>" width="100%" class="related-img" alt="">
                </div>
                <div class="related-img-col">
                    <img src="uploads/<?= $fetch['photo_three'] ?>" width="100%" class="related-img" alt="">
                </div>
             
            </div>
            

        </div>
    
        <div class="single-prot-details">
            <h6> Order Invoice</h6>
        

            <!-- Tab panes -->
								<div class="tab-content">
									<!-- shopping-cart start -->
									<div class="tab-pane active" id="shopping-cart">


                                    <h4>Name: <?= $fetch1['fname'] ?></h4>

                                    <h4>Address: <?= $fetch1['address'] ?></h4>

                                    <h4>Email: <?= $fetch1['email'] ?></h4>

                                    <h2>
                                        Ordered Items
                                    </h2>

                                    <table>
														<thead>
															<tr>
																<th class="product-thumbnail">Product</th>
																<th class="product-quantity">Quantity</th>
																<th class="product-remove">Remove</th>
															</tr>
														</thead>
														<tbody>
														
														<?php 

														foreach ($_SESSION['shopping_cart'] as $key => $product) {
															# code...

														?>
															
															<tr>
																<td class="product-thumbnail  text-left">
																	<!-- Single-product start -->
																	<div class="single-product">
																		<div class="product-img">
																			<a href="productPage.php?id=<?= $product['id'] ?>"> </a>
																		</div>
																		<div class="product-info">
																			<h4 class="post-title"><a class="text-light-black" href="#"> <?= $product['name'] ?> </a></h4>
																			
																		</div>
																	</div>
																	<!-- Single-product end -->												
																</td>
																<td class="product-quantity">
																<span><?= $product['quantity'] ?></span>
																</td>
																<td class="product-remove">
																	<a href="cart.php?delete=<?php echo $product['id']; ?>">X</a>
																</td>
															</tr>

															<?php

																$total = $total + ($product['quantity'] * $product['price']);

															} ?>


														</tbody>
													</table>

                                    <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
									
									</div>

        
									
								
								</div>
          
           
            

           
        </div>
      
       
       
          
     </section>

   
  






<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm Order</h4>
        </div>
        <div class="modal-body">
          <p>
           <a href="checkout.php">Proceed the order</a> 
        </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>






  <script>
    let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
      subMenu.classList.toggle("open-menu");
    }
 

    var MainImg = document.getElementById("MainImg")
    var smallImg = document.getElementsByClassName("related-img")
    smallImg[0].onclick = function(){
        MainImg.src = smallImg[0].src;
    }
    smallImg[1].onclick = function(){
        MainImg.src = smallImg[1].src;
    }
    smallImg[2].onclick = function(){
        MainImg.src = smallImg[2].src;
    }
    smallImg[3].onclick = function(){
        MainImg.src = smallImg[3].src;
    }
    smallImg[4].onclick = function(){
        MainImg.src = smallImg[4].src;
    }


    
   
  </script>

  <script>
    $('#modal').modal('toggle')
  </script>

</body>
</html>
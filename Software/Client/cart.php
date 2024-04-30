<?php
include 'dbConfig.php';
$product_ids = array();
error_reporting(0);
//session_destroy();
$decoded_image = base64_decode($_POST['photo']);


if(filter_input(INPUT_POST, 'add_to_cart')){

	
if(isset($_SESSION['shopping_cart'])){


$product_ids =  array_column($_SESSION['shopping_cart'],'id');

$count = count($_SESSION['shopping_cart']);



if(!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
  
  $_SESSION['shopping_cart'][$count] = array(


        "id" => filter_input(INPUT_GET, 'id'),
		"name" => filter_input(INPUT_POST, 'name'),
        // "photo" => filter_input(INPUT_POST, 'photo'),
		// "price" => filter_input(INPUT_POST, 'price'),
		"quantity" => filter_input(INPUT_POST, 'quantity')

  );

}  else{
	for ($i=0; $i < count($product_ids) ; $i++) { 
		if($product_ids[$i] == filter_input(INPUT_GET, 'id')){
			$_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
		}
	}
}

$count = count($_SESSION['shopping_cart']);


} else{

	$_SESSION['shopping_cart'][0] = array(

		"id" => filter_input(INPUT_GET, 'id'),
		"name" => filter_input(INPUT_POST, 'name'),
        // "photo" => filter_input(INPUT_POST, 'photo'),
		// "price" => filter_input(INPUT_POST, 'price'),
		"quantity" => filter_input(INPUT_POST, 'quantity')


	);
    $count = count($_SESSION['shopping_cart']);

}


}
if(!empty($_SESSION['shopping_cart'])){
     $count = count($_SESSION['shopping_cart']);
    
    }
// pre_r($_SESSION);

// function pre_r($array){
//     echo '<pre>';
//     print_r($array);
//     echo '</pre>';
// }



if(filter_input(INPUT_GET, 'delete')){
    //loop through all products in the shopping cart until it matches with GET id variable
    foreach($_SESSION['shopping_cart'] as $key => $product){
        if ($product['id'] == filter_input(INPUT_GET, 'delete')){
            //remove product from the shopping cart when it matches with the GET id
            unset($_SESSION['shopping_cart'][$key]);
        }
    }

    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);

    header('Location: cart-page.php');
}


?>
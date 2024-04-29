<?php
include 'db_connection.php';

$query = "SELECT name, total_quantity FROM products";
$result = mysqli_query($connection, $query);

$product_data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $product_data[] = $row; // Push each row to the $product_data array
}

mysqli_close($connection);

echo json_encode($product_data);
?>

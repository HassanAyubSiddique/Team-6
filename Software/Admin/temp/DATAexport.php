<?php
// Database connection parameters
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; 
$database = "wms"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the products table
$queryProducts = "SELECT name, total_quantity FROM products";
$resultProducts = $conn->query($queryProducts);

// Initialize arrays to store product names and quantities
$productNames = [];
$productQuantities = [];

// Fetch product names and quantities from the result set
if ($resultProducts->num_rows > 0) {
    while ($row = $resultProducts->fetch_assoc()) {
        // Concatenate the name and quantity with a separator
        $productNameWithQuantity = $row['name'] . ': ' . $row['total_quantity'];
        
        // Store the concatenated string in the productNames array
        $productNames[] = $productNameWithQuantity;
        
        // Store the quantity separately in the productQuantities array
        $productQuantities[] = $row['total_quantity'];
    }
}

// Fetch data from the raw materials table
$queryRawMaterials = "SELECT name, total_quantity FROM raw_materials";
$resultRawMaterials = $conn->query($queryRawMaterials);

// Initialize arrays to store raw material names and quantities
$rawMaterialNames = [];
$rawMaterialQuantities = [];

// Fetch raw material names and quantities from the result set
if ($resultRawMaterials->num_rows > 0) {
    while ($row = $resultRawMaterials->fetch_assoc()) {
        // Concatenate the name and quantity with a separator
        $rawMaterialNameWithQuantity = $row['name'] . ': ' . $row['total_quantity'];
        
        // Store the concatenated string in the rawMaterialNames array
        $rawMaterialNames[] = $rawMaterialNameWithQuantity;
        
        // Store the quantity separately in the rawMaterialQuantities array
        $rawMaterialQuantities[] = $row['total_quantity'];
    }
}

// Fetch order data from the database with a count for each day
$queryOrders = "SELECT DATE(created_on) AS order_date, COUNT(*) AS order_count FROM orders GROUP BY DATE(created_on)";
$resultOrders = $conn->query($queryOrders);

// Initialize arrays to store order dates and counts
$orderLabels = [];
$orderData = [];

// Fetch order dates and counts from the result set
if ($resultOrders->num_rows > 0) {
    while ($row = $resultOrders->fetch_assoc()) {
        $orderLabels[] = $row['order_date']; // Store the order date
        $orderData[] = $row['order_count']; // Store the order count
    }
}

// Close database connection
$conn->close();

// Convert PHP arrays to JavaScript arrays
$productNamesJS = json_encode($productNames);
$productQuantitiesJS = json_encode($productQuantities);
$rawMaterialNamesJS = json_encode($rawMaterialNames);
$rawMaterialQuantitiesJS = json_encode($rawMaterialQuantities);
$orderLabelsJS = json_encode($orderLabels);
$orderDataJS = json_encode($orderData);

// Output the JavaScript arrays as JSON
echo "var productNames = " . $productNamesJS . ";\n";
echo "var productQuantities = " . $productQuantitiesJS . ";\n";
echo "var rawMaterialNames = " . $rawMaterialNamesJS . ";\n";
echo "var rawMaterialQuantities = " . $rawMaterialQuantitiesJS . ";\n";
echo "var orderLabels = " . $orderLabelsJS . ";\n";
echo "var orderData = " . $orderDataJS . ";\n";

// Execute the Python script
$output = shell_exec('python DATA.py');
echo $output; // Output any result or message from the Python script

?>

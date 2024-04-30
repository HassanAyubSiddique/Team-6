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
// Fetch order dates and counts from the result set
if ($resultOrders->num_rows > 0) {
    while ($row = $resultOrders->fetch_assoc()) {
        // Concatenate the date and count for the label
        $label = $row['order_date'] . ' (' . $row['order_count'] . ' orders)';
        
        // Store the label
        $orderLabels[] = $label;
        
        // Store the order count
        $orderData[] = $row['order_count'];
    }
}
// Fetch order data from the database with a count for each day
$queryOrders = "SELECT client_id, COUNT(*) AS order_count FROM orders WHERE YEAR(created_on) = 2023 GROUP BY client_id";
$resultOrders = $conn->query($queryOrders);

// Initialize arrays to store client IDs and order counts
$clientIDs = [];
$clientOrderCounts = [];

// Fetch client IDs and order counts from the result set
if ($resultOrders->num_rows > 0) {
    while ($row = $resultOrders->fetch_assoc()) {
        $clientIDs[] = $row['client_id'];
        $clientOrderCounts[] = $row['order_count'];
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
$clientIDsJS = json_encode($clientIDs);
$clientOrderCountsJS = json_encode($clientOrderCounts);

// Output the JavaScript arrays as JSON
echo "var productNames = " . $productNamesJS . ";\n";
echo "var productQuantities = " . $productQuantitiesJS . ";\n";
echo "var rawMaterialNames = " . $rawMaterialNamesJS . ";\n";
echo "var rawMaterialQuantities = " . $rawMaterialQuantitiesJS . ";\n";
echo "var orderLabels = " . $orderLabelsJS . ";\n";
echo "var orderData = " . $orderDataJS . ";\n";
echo "var clientIDs = " . $clientIDsJS . ";\n";
echo "var clientOrderCounts = " . $clientOrderCountsJS . ";\n";
 
?>

<?php
// Database connection parameters
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; 
$database = "wms"; // Change this to your database name

// Get the selected start and end dates from the AJAX request
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch updated order data from the database based on the selected start and end dates
$queryOrders = "SELECT DATE(created_on) AS order_date, COUNT(*) AS order_count FROM orders WHERE DATE(created_on) BETWEEN '$start_date' AND '$end_date' GROUP BY DATE(created_on)";
$resultOrders = $conn->query($queryOrders);

// Initialize arrays to store order dates and counts
$orderLabels = [];
$orderData = [];

// Fetch order dates and counts from the result set
if ($resultOrders->num_rows > 0) {
    while ($row = $resultOrders->fetch_assoc()) {
        $label = $row['order_date'] . ' (' . $row['order_count'] . ' orders)';
        
        // Store the label
        $orderLabels[] = $label;
        $orderData[] = $row['order_count']; // Store the order count
    }
}

// Close database connection
$conn->close();

// Convert PHP arrays to JSON format
$response = [
    'labels' => $orderLabels,
    'data' => $orderData
];

// Output the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

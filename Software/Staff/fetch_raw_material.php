<?php
 include 'DatabaseConnection.php';

// Query to fetch raw material data from the database
$query = "SELECT * FROM raw_materials";
$result = mysqli_query($con, $query);

// Fetch data into an associative array
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Output JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>

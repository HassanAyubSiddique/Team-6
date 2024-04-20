<?php
include 'DatabaseConnection.php';

// Get the raw material id from the URL parameter
$rawMaterialId = $_GET['id'];

// Perform any necessary operations to delete the raw material...
// For example, set the stock quantity to 0

// Redirect back to the staff order raw material page
header('Location: StafforderRawMaterial.html');
exit();
?>

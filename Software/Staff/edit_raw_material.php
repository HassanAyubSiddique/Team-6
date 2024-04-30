<?php
 include 'db_connection.php';


// Get the raw material id from the URL parameter
$rawMaterialId = $_GET['id'];

// Perform any necessary operations to edit the raw material...

// Redirect back to the staff order raw material page
header('Location: StafforderRawMaterial.html');
exit();
?>

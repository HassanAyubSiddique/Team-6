<?php
// Include database connection
include 'db_connection.php';

// Get client ID from the URL
if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];

    // Update client status to "Approved"
    $sql = "UPDATE clients SET status = 'Approved' WHERE client_id = $client_id";
    if ($conn->query($sql) === TRUE) {
        // Redirect back to clients page
        header("Location: ../clients.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Client ID not provided";
}

// Close connection
$conn->close();
?>

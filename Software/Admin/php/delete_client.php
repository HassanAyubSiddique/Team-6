<?php
// Include database connection
include 'db_connection.php';

// Get client ID from the URL
if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];

    // Delete orders associated with the client
    $sql_delete_orders = "DELETE FROM orders WHERE client_id = $client_id";
    if ($conn->query($sql_delete_orders) === TRUE) {
        // Orders deleted successfully, now delete the client
        $sql_delete_client = "DELETE FROM clients WHERE client_id = $client_id";
        if ($conn->query($sql_delete_client) === TRUE) {
            // Redirect back to clients page with success message
            header("Location: ../Customer.php?success=Client and associated orders deleted successfully");
            exit();
        } else {
            echo "Error deleting client record: " . $conn->error;
        }
    } else {
        echo "Error deleting orders: " . $conn->error;
    }
} else {
    echo "Client ID not provided";
}

// Close connection
$conn->close();
?>

<?php
// Include database connection
include 'db_connection.php';

// Function to reject a client by updating their status
function rejectClient($clientID, $conn)
{
    // Update client status to "Rejected"
    $sql = "UPDATE clients SET status = 'Rejected' WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $clientID);

    if ($stmt->execute()) {
        // Redirect back to clients page
        header("Location: ../Customer.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Get client ID from the URL
if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    rejectClient($client_id, $conn);
} else {
    echo "Client ID not provided";
}

// Close connection
$conn->close();
?>

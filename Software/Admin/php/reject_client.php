<?php
// Include database connection
include 'db_connection.php';

class ClientManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to reject a client by updating their status
    public function rejectClient($clientID) {
        // Update client status to "Rejected"
        $sql = "UPDATE clients SET status = 'Rejected' WHERE client_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $clientID);

        if ($stmt->execute()) {
            // Redirect back to clients page
            header("Location: ../Customer.php");
            exit();
        } else {
            echo "Error updating record: " . $this->conn->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Create an instance of ClientManager
$clientManager = new ClientManager($conn);

// Get client ID from the URL
if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];
    // Reject the client
    $clientManager->rejectClient($client_id);
} else {
    echo "Client ID not provided";
}

// Close connection
$conn->close();
?>

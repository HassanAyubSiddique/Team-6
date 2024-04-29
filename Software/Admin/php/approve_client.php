<?php
// Include database connection
include 'db_connection.php';

/**
 * Class ClientManager handles operations related to clients.
 */
class ClientManager {
    private $conn;

    /**
     * Constructor to initialize the ClientManager with the provided database connection.
     * @param mysqli $conn The database connection object.
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Updates the status of a client to "Approved".
     * @param int $clientId The ID of the client.
     * @return bool True if the update is successful, false otherwise.
     */
    public function approveClient($clientId) {
        // Update client status to "Approved"
        $sql = "UPDATE clients SET status = 'Approved' WHERE client_id = $clientId";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Process the approval of a client.
 * @param mysqli $conn The database connection object.
 */
function processClientApproval($conn) {
    // Check if client ID is provided in the URL
    if (isset($_GET['client_id'])) {
        $clientId = $_GET['client_id'];

        // Create ClientManager object
        $clientManager = new ClientManager($conn);

        // Update client status to "Approved"
        if ($clientManager->approveClient($clientId)) {
            // Redirect back to clients page
            header("Location: ../Customer.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Client ID not provided";
    }
}

// Process client approval
processClientApproval($conn);

// Close connection
$conn->close();
?>

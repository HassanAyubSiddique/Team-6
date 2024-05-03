<?php
// Include database connection
include 'db_connection.php';

/**
 * Class ClientManager handles client-related database operations.
 */
class delete_client {
    private $conn;

    /**
     * Constructor to initialize the ClientManager with a database connection.
     * @param mysqli $conn The database connection object.
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Deletes a client and associated orders from the database.
     * @param int $client_id The ID of the client to delete.
     * @return string|null Error message if deletion fails, null otherwise.
     */
    public function deleteClientAndOrders($client_id) {
        // Delete orders associated with the client
        $sql_delete_orders = "DELETE FROM orders WHERE client_id = $client_id";
        if ($this->conn->query($sql_delete_orders) === TRUE) {
            // Orders deleted successfully, now delete the client
            $sql_delete_client = "DELETE FROM clients WHERE client_id = $client_id";
            if ($this->conn->query($sql_delete_client) === TRUE) {
                return null; // Deletion successful, no error
            } else {
                return "Error deleting client record: " . $this->conn->error;
            }
        } else {
            return "Error deleting orders: " . $this->conn->error;
        }
    }

    /**
     * Deletes a client and associated orders based on the client ID from the URL.
     * Displays error message if client ID is not provided.
     */
    public function deleteClientAndOrdersFromURL() {
        // Get client ID from the URL
        if (isset($_GET['client_id'])) {
            $client_id = $_GET['client_id'];

            // Delete client and associated orders
            $error_message = $this->deleteClientAndOrders($client_id);

            // Check if there was an error
            if ($error_message === null) {
                // Redirect back to clients page with success message
                header("Location: ../Customer.php?success=Client and associated orders deleted successfully");
                exit();
            } else {
                // Display error message
                echo $error_message;
            }
        } else {
            echo "Client ID not provided";
        }
    }
}

// Create ClientManager object
$clientManager = new delete_client($conn);

// Delete client and associated orders based on the client ID from the URL
$clientManager->deleteClientAndOrdersFromURL();

// Close connection
$conn->close();
?>

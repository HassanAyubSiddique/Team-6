<?php
// Include database connection
include 'db_connection.php';

class ClientRetriever {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to retrieve clients with pagination
    public function retrieveClients($clientsPerPage, $currentPage) {
        // Define variables for pagination
        $start = ($currentPage - 1) * $clientsPerPage;

        // Query to fetch clients data with pagination
        $sql = "SELECT * FROM clients LIMIT $start, $clientsPerPage";
        $result = $this->conn->query($sql);

        echo "<link rel='stylesheet' type='text/css' href='../style.css'>";

        // Check for successful execution
        if ($result) {
            // Check if any rows were returned
            if ($result->num_rows >= 0) {
                // Loop through results and build table rows
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["client_id"] . "</td>";
                    echo "<td>" . $row["first_name"] . "</td>";
                    echo "<td>" . $row["last_name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td class='" . strtolower($row["status"]) . "'>" . $row["status"] . "</td>"; // Adding class based on status

                    // Displaying image if it's in binary format
                    $profilePicture = $row["profile_pic"];
                    if ($profilePicture) {
                        $imageData = base64_encode($profilePicture);
                        $src = 'data:image/jpeg;base64,'.$imageData;
                        echo "<td><img src='" . $src . "' alt='" . $row["first_name"] . " " . $row["last_name"] . "' style='max-width: 100px;'></td>";
                    } else {
                        echo "<td>No image</td>";
                    }

                    echo "<td class='button-container'>";
                    
                    // Approve button if status is Pending
                    if ($row["status"] == "Pending") {
                        echo "<button class='edit-btn' onclick='approveClient(" . $row["client_id"] . ")'><i class='fas fa-check'></i>Approve</button>";
                    }

                    // Reject button if status is Pending
                    if ($row["status"] == "Pending") {
                        echo "<button class='edit-btn' onclick='rejectClient(" . $row["client_id"] . ")'><i class='fas fa-trash'></i>Reject</button>";
                    }

                    // Delete button
                    echo "<button class='delete-btn' onclick='deleteClient(" . $row["client_id"] . ")'><i class='fas fa-trash'></i>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                
                echo "</table>";

                // Pagination controls and Clients per page dropdown
                echo "<div class='pagination'>"; 
                echo "<select id='perPage' onchange='changePerPage()'>";
                $perPageOptions = [10, 20, 50, 100];
                foreach ($perPageOptions as $option) {
                    echo "<option value='$option' ";
                    if ($option == $clientsPerPage) {
                        echo "selected";
                    }
                    echo ">$option</option>";
                }
                echo "</select>"; 
                echo "<button class='edit-btn' onclick='previousPage()'><i class='fa-solid fa-left-long'></i>Previous</button>";
                echo "<button class='edit-btn' onclick='nextPage()'><i class='fa-solid fa-right-long'></i>Next</button>";
                echo "</div>";
            } else {
                echo "<p>No clients found</p>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
}

// Instantiate the ClientRetriever class
$clientRetriever = new ClientRetriever($conn);

// Define variables for pagination and clients per page
$clientsPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Call the function to retrieve clients
$clientRetriever->retrieveClients($clientsPerPage, $currentPage);

// Close connection
$conn->close();
?>

<script>
function deleteClient(client_id) {
    if (confirm("Are you sure you want to delete this client?")) {
        window.location.href = "php/delete_client.php?client_id=" + client_id;
    }
}

function approveClient(client_id) {
    if (confirm("Are you sure you want to approve this client?")) {
        window.location.href = "php/approve_client.php?client_id=" + client_id;
    }
}

function rejectClient(client_id) {
    if (confirm("Are you sure you want to reject this client?")) {
        window.location.href = "php/reject_client.php?client_id=" + client_id;
    }
}

function previousPage() {
    <?php
    if ($currentPage > 1) {
        $prevPage = $currentPage - 1;
        echo "window.location.href = 'Customer.php?page=$prevPage&per_page=$clientsPerPage';";
    }
    ?>
}

function nextPage() {
    <?php
        $nextPage = $currentPage + 1;
        echo "window.location.href = 'Customer.php?page=$nextPage&per_page=$clientsPerPage';";
    ?>
}

function changePerPage() {
    var perPage = document.getElementById("perPage").value;
    <?php
    echo "window.location.href = 'Customer.php?page=1&per_page=' + perPage;";
    ?>
} 
</script>

<?php
// Include database connection
include 'db_connection.php';

class OrderRetriever {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to retrieve orders with pagination
    public function retrieveOrders($ordersPerPage, $currentPage) {
        // Define variables for pagination
        $start = ($currentPage - 1) * $ordersPerPage;

        // Query to fetch orders data with pagination
        $sql = "SELECT * FROM orders LIMIT $start, $ordersPerPage";
        $result = $this->conn->query($sql);

        echo "<link rel='stylesheet' type='text/css' href='../style.css'>";

        // Check for successful execution
        if ($result) {
            // Check if any rows were returned
            if ($result->num_rows >= 0) {
                // Loop through results and build table rows  
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["order_id"] . "</td>";
                    echo "<td>" . $row["client_id"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>" . $row["created_on"] . "</td>";
                    echo "<td>" . $row["delivery_reference"] . "</td>";
                    echo "<td><button class='edit-btn' onclick='editOrder(" . $row["order_id"] . ")'><i class='fas fa-edit'></i>Edit</button></td>";
                    echo "</tr>";
                }
                
                echo "</table>";

                // Pagination controls and Orders per page dropdown
                echo "<div class='pagination'>"; 
                echo "<select id='perPage' onchange='changePerPage()'>";
                $perPageOptions = [10, 20, 50, 100];
                foreach ($perPageOptions as $option) {
                    echo "<option value='$option' ";
                    if ($option == $ordersPerPage) {
                        echo "selected";
                    }
                    echo ">$option</option>";
                }
                echo "</select>"; 
                echo "<button class='edit-btn' onclick='previousPage()'><i class='fa-solid fa-left-long'></i>Previous</button>";
                echo "<button class='edit-btn' onclick='nextPage()'><i class='fa-solid fa-right-long'></i>Next</button>";
                echo "</div>";
            } else {
                echo "<p>No orders found</p>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }
}

// Instantiate the OrderRetriever class
$orderRetriever = new OrderRetriever($conn);

// Define variables for pagination and orders per page
$ordersPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

// Call the function to retrieve orders
$orderRetriever->retrieveOrders($ordersPerPage, $currentPage);

// Close connection
$conn->close();
?>

<script>
function editOrder(order_id) {
    window.location.href = "./php/edit_order.php?order_id=" + order_id;
}

function previousPage() {
    <?php
    if ($currentPage > 1) {
        $prevPage = $currentPage - 1;
        echo "window.location.href = 'PurchaseOrder.php?page=$prevPage&per_page=$ordersPerPage';";
    }
    ?>
}

function nextPage() {
    <?php
        $nextPage = $currentPage + 1;
        echo "window.location.href = 'PurchaseOrder.php?page=$nextPage&per_page=$ordersPerPage';";
    ?>
}

function changePerPage() {
    var perPage = document.getElementById("perPage").value;
    <?php
    echo "window.location.href = 'PurchaseOrder.php?page=1&per_page=' + perPage;";
    ?>
} 
</script>

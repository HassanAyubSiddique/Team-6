<?php
// Include database connection
include 'db_connection.php';

// Define variables for pagination and orders per page
$ordersPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentPage - 1) * $ordersPerPage;

// Query to fetch orders data with pagination
$sql = "SELECT * FROM orders LIMIT $start, $ordersPerPage";
$result = $conn->query($sql);

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
            echo "<td><button onclick='editOrder(" . $row["order_id"] . ")'>Edit</button></td>";
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
        echo "<button onclick='previousPage()'>Previous</button>";
        echo "<button onclick='nextPage()'>Next</button>";
        echo "</div>";
    } else {
        echo "<p>No orders found</p>";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

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

<?php
// Include database connection and retrieve products query
include 'db_connection.php';

// Define variables for pagination and products per page
$productsPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentPage - 1) * $productsPerPage;

// Query to fetch product data with pagination
$sql = "SELECT product_id, name, description, total_quantity, status, main_image FROM products LIMIT $start, $productsPerPage";
$result = $conn->query($sql);

echo "<link rel='stylesheet' type='text/css' href='../style.css'>";

// Check for successful execution
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows >= 0) {
        // Loop through results and build table rows
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["product_id"] . "</td>";
            echo "<td class='product-name' onclick='toggleBatches(" . $row["product_id"] . ")'>" . $row["name"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td>" . $row["total_quantity"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($row["main_image"]) . "' alt='" . $row["name"] . "' style='max-width: 100%; height: auto;' onclick='openImagePopup(" . $row["product_id"] . ")'></td>";
            echo "<td>";
            if ($row["status"] == "Listed") {
                echo "<button onclick='unlistProduct(" . $row["product_id"] . ")'>Unlist</button>";
            } else {
                echo "<button onclick='listProduct(" . $row["product_id"] . ")'>List</button>";
            }
            echo "<button onclick='deleteProduct(" . $row["product_id"] . ")'>Delete</button>";
            echo "<button onclick='editProduct(" . $row["product_id"] . ")'>Edit</button>";
            echo "<button onclick='addBatch(" . $row["product_id"] . ")'>Add Batch</button>"; // Button for adding batch
            echo "<button onclick='useProducts(" . $row["product_id"] . ")'>Use Products</button>"; // Button for using products
            echo "</td>";
            echo "</tr>";

            // Fetch and display batches for each product
            echo "<tr id='batches-" . $row["product_id"] . "' style='display: none;'>";
            echo "<td colspan='7'>";
            echo "<table class='batches-table'>"; // Subtable for batches
            echo "<thead><tr><th>Batch ID</th><th>BB Date</th><th>Quantity</th><th>SKU</th></tr></thead>";
            echo "<tbody>";
            $product_id = $row["product_id"];
            $sql_batches = "SELECT * FROM product_batches WHERE product_id = $product_id";
            $result_batches = $conn->query($sql_batches);
            if ($result_batches->num_rows > 0) {
                while($batch_row = $result_batches->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $batch_row["batch_id"] . "</td>";
                    echo "<td>" . $batch_row["bbd"] . "</td>";
                    echo "<td>" . $batch_row["quantity"] . "</td>";
                    echo "<td>" . $batch_row["sku_code"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No batches found</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Pagination controls and Products per page dropdown
        echo "<div class='pagination'>";
        echo "<label for='perPage'>Products per page:</label>";
        echo "<select id='perPage' onchange='changePerPage()'>";
        $perPageOptions = [10, 20, 50, 100];
        foreach ($perPageOptions as $option) {
            echo "<option value='$option' ";
            if ($option == $productsPerPage) {
                echo "selected";
            }
            echo ">$option</option>";
        }
        echo "</select>"; 
            echo "<button onclick='previousPage()'>Previous</button>";
        
            echo "<button onclick='nextPage()'>Next</button>";
    
        echo "</div>";
    } else {
        echo "<p>No products found</p>";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>

<script>
function deleteProduct(product_id) {
    if (confirm("Are you sure you want to delete this product?")) {
        window.location.href = "php/delete_product.php?product_id=" + product_id;
    }
}

function listProduct(product_id) {
    window.location.href = "php/list_product.php?product_id=" + product_id;
}

function unlistProduct(product_id) {
    window.location.href = "php/unlist_product.php?product_id=" + product_id;
}

function editProduct(product_id) {
    window.location.href = "php/edit_product.php?product_id=" + product_id;
}

function addBatch(product_id) {
    window.location.href = "php/add_batch.php?product_id=" + product_id;
}

function useProducts(product_id) {
    window.location.href = "php/use_products.php?product_id=" + product_id;
}

function toggleBatches(product_id) {
    var batches = document.getElementById("batches-" + product_id);
    if (batches.style.display === "none") {
        batches.style.display = "table-row";
    } else {
        batches.style.display = "none";
    }
}

function previousPage() {
    <?php
    if ($currentPage > 1) {
        $prevPage = $currentPage - 1;
        echo "window.location.href = 'ViewProduct.php?page=$prevPage&per_page=$productsPerPage';";
    }
    ?>
}

function nextPage() {
    <?php
        $nextPage = $currentPage + 1;
        echo "window.location.href = 'ViewProduct.php?page=$nextPage&per_page=$productsPerPage';";
    
    ?>
}

function changePerPage() {
    var perPage = document.getElementById("perPage").value;
    <?php
    echo "window.location.href = 'ViewProduct.php?page=1&per_page=' + perPage;";
    ?>
}

function openImagePopup(product_id) {
    window.location.href = "php/product_images.php?product_id=" + product_id;
}
</script>

<?php
// Include database connection and retrieve products query
include 'db_connection.php';

// Query to fetch product data
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Check for successful execution
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Loop through results and build table rows
        echo "<style>";
        echo "
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #f2f2f2;
            }

            .product-name {
                cursor: pointer;
                color: #0366d6;
                font-weight: bold;
            }

            .batches-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            .batches-table th, .batches-table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }

            .batches-table th {
                background-color: #f2f2f2;
            }

            .batches-table tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            .batches-table td {
                vertical-align: middle;
            }

            .batches-table .no-batches {
                font-style: italic;
                color: #888;
            }

            .batch-info {
                display: flex;
                align-items: center;
            }

            .batch-info img {
                max-width: 50px;
                margin-right: 10px;
            }

            .batch-info .batch-details {
                flex-grow: 1;
            }

            .batch-info .batch-details p {
                margin: 0;
            }
            
        ";
        echo "</style>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["product_id"] . "</td>";
            echo "<td class='product-name' onclick='toggleBatches(" . $row["product_id"] . ")'>" . $row["name"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td>" . $row["total_quantity"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "<td><img src='data:image/jpeg;base64," . base64_encode($row["main_image"]) . "' alt='" . $row["name"] . "' style='max-width: 100px;'></td>";
            echo "<td>";
            if ($row["status"] == "Listed") {
                echo "<button onclick='unlistProduct(" . $row["product_id"] . ")'>Unlist</button>";
            } else {
                echo "<button onclick='listProduct(" . $row["product_id"] . ")'>List</button>";
            }
            echo "<button onclick='deleteProduct(" . $row["product_id"] . ")'>Delete</button>";
            echo "<button onclick='editProduct(" . $row["product_id"] . ")'>Edit</button>";
            echo "<button onclick='addBatch(" . $row["product_id"] . ")'>Add Batch</button>"; // Button for adding batch
            echo "</td>";
            echo "</tr>";

            // Fetch and display batches for each product
            echo "<tr id='batches-" . $row["product_id"] . "' style='display: none;'>";
            echo "<td colspan='7'>";
            echo "<table class='batches-table'>"; // Subtable for batches
            echo "<thead><tr><th>BB Date</th><th>Quantity</th><th>SKU</th></tr></thead>";
            echo "<tbody>";
            $product_id = $row["product_id"];
            $sql_batches = "SELECT * FROM product_batches WHERE product_id = $product_id";
            $result_batches = $conn->query($sql_batches);
            if ($result_batches->num_rows > 0) {
                while($batch_row = $result_batches->fetch_assoc()) {
                    echo "<tr>";
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
    } else {
        echo "<tr><td colspan='7'>No products found</td></tr>";
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

function toggleBatches(product_id) {
    var batches = document.getElementById("batches-" + product_id);
    if (batches.style.display === "none") {
        batches.style.display = "table-row";
    } else {
        batches.style.display = "none";
    }
}
</script>

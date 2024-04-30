<?php
include 'db_connection.php';

class ProductManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getProducts($perPage, $currentPage) {
        $start = ($currentPage - 1) * $perPage;
        $sql = "SELECT product_id, name, description, total_quantity, status, main_image FROM products LIMIT $start, $perPage";
        $result = $this->conn->query($sql);

        $products = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    public function getProductBatches($productId) {
        $sql = "SELECT batch_id, bbd, quantity, sku_code FROM product_batches WHERE product_id = $productId";
        $result = $this->conn->query($sql);

        $batches = [];
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $batches[] = $row;
            }
        }
        return $batches;
    }
}

$productManager = new ProductManager($conn);
$productsPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$products = $productManager->getProducts($productsPerPage, $currentPage);

if ($products) {
    foreach ($products as $product) {
        // Display product info
        echo "<tr>";
        echo "<td>" . $product["product_id"] . "</td>";
        echo "<td class='product-name' onclick='toggleBatches(" . $product["product_id"] . ")'>" . $product["name"] . "</td>";
        echo "<td>" . $product["description"] . "</td>";
        echo "<td>" . $product["total_quantity"] . "</td>";
        echo "<td>" . $product["status"] . "</td>";
        echo "<td><img src='data:image/jpeg;base64," . base64_encode($product["main_image"]) . "' alt='" . $product["name"] . "' style='max-width: 100%; height: auto;'></td>";
        echo "<td>";
        echo "<button class='edit-btn' onclick='addBatch(" . $product["product_id"] . ")'><i class='fas fa-plus'></i>Add Batch</button>"; // Button for adding batch
        echo "</td>";
        echo "</tr>";

        // Display batches
        $batches = $productManager->getProductBatches($product['product_id']);
        echo "<tr id='batches-" . $product["product_id"] . "' style='display: none;'>";
        echo "<td colspan='7'>";
        echo "<table class='batches-table'>"; // Subtable for batches
        echo "<thead><tr><th>Batch ID</th><th>BB Date</th><th>Quantity</th><th>SKU</th></tr></thead>";
        echo "<tbody>";
        if (!empty($batches)) {
            foreach ($batches as $batch) {
                echo "<tr>";
                echo "<td>" . $batch["batch_id"] . "</td>";
                echo "<td>" . $batch["bbd"] . "</td>";
                echo "<td>" . $batch["quantity"] . "</td>";
                echo "<td>" . $batch["sku_code"] . "</td>";
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
    echo "<div class='pagination' style='margin-top: 20px;'>";
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
    echo "<button class='edit-btn' onclick='previousPage()'><i class='fa-solid fa-left-long'></i>Previous</button>";
    echo "<button class='edit-btn' onclick='nextPage()'><i class='fa-solid fa-right-long'></i>Next</button>";
    echo "</div>";
} else {
    echo "<p>No products found</p>";
}
?>

<script>


function addBatch(product_id) {
    window.location.href = "add_batch.php?product_id=" + product_id;
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

</script>

<?php
// Include database connection
include 'db_connection.php';

// Define variables for pagination and materials per page
$materialsPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentPage - 1) * $materialsPerPage;

// Query to fetch raw material data with pagination
$sql = "SELECT * FROM raw_materials LIMIT $start, $materialsPerPage";
$result = $conn->query($sql);
echo "<link rel='stylesheet' type='text/css' href='../style.css'>";

// Check for successful execution
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows >= 0) {
        // Loop through results and build table rows

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["raw_material_id"] . "</td>";
            echo "<td class='raw-material-name' onclick='toggleBatches(" . $row["raw_material_id"] . ")'>" . $row["name"] . "</td>"; // Update here to include onclick event
            echo "<td>" . $row["description"] . "</td>";
            echo "<td>" . $row["total_quantity"] . "</td>";
            echo "<td class='" . getStatusClass($row["status"]) . "'>" . $row["status"] . "</td>"; // Status column
            // Display image as <img> tag
            $imageData = base64_encode($row["image"]); // Convert binary image data to base64
            $src = 'data:image/jpeg;base64,'.$imageData; // Specify image MIME type
            echo "<td><img src='{$src}' alt='Raw Material Image' class='raw-material-image'></td>";
            echo "<td>";
            if ($row["status"] == "Listed") {
                echo "<button class='btn btn-unlist' onclick='unlistRawMaterial(" . $row["raw_material_id"] . ")'>Unlist</button>";
            } else {
                echo "<button class='btn btn-list' onclick='listRawMaterial(" . $row["raw_material_id"] . ")'>List</button>";
            }
            echo "<button class='btn btn-delete' onclick='deleteRawMaterial(" . $row["raw_material_id"] . ")'>Delete</button>";
            echo "<button class='btn btn-edit' onclick='editRawMaterial(" . $row["raw_material_id"] . ")'>Edit</button>";
            echo "<button class='btn btn-add-batch' onclick='addBatch(" . $row["raw_material_id"] . ")'>Add Batch</button>"; // Button for adding batch
            echo "<button class='btn btn-use-raw-materials' onclick='useRawMaterials(" . $row["raw_material_id"] . ")'>Use Raw Materials</button>"; // Button for using raw materials
            echo "</td>";
            echo "</tr>";

            // Fetch and display batches for each raw material
            echo "<tr id='batches-" . $row["raw_material_id"] . "' style='display: none;'>";
            echo "<td colspan='7'>";
            echo "<table class='batches-table'>"; // Subtable for batches
            echo "<thead><tr><th>Batch ID</th><th>BB Date</th><th>Quantity</th><th>SKU</th></tr></thead>";
            echo "<tbody>";
            $raw_material_id = $row["raw_material_id"];
            $sql_batches = "SELECT * FROM raw_material_batches WHERE raw_material_id = $raw_material_id";
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
        echo "</table>";

        // Pagination controls and Products per page dropdown
        echo "<div class='pagination'>"; 
        echo "<select id='perPage' onchange='changePerPage()'>";
        $perPageOptions = [10, 20, 50, 100];
        foreach ($perPageOptions as $option) {
            echo "<option value='$option' ";
            if ($option == $materialsPerPage) {
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

function getStatusClass($status) {
    return ($status == "Listed") ? "status-listed" : "status-unlisted";
}
?>

<script>
function deleteRawMaterial(raw_material_id) {
    if (confirm("Are you sure you want to delete this raw material?")) {
        window.location.href = "php/delete_raw_material.php?raw_material_id=" + raw_material_id;
    }
}

function editRawMaterial(raw_material_id) {
    window.location.href = "php/edit_raw_material.php?raw_material_id=" + raw_material_id;
}

function listRawMaterial(raw_material_id) {
    window.location.href = "php/list_raw_material.php?raw_material_id=" + raw_material_id;
}

function unlistRawMaterial(raw_material_id) {
    window.location.href = "php/unlist_raw_material.php?raw_material_id=" + raw_material_id;
}

function addBatch(raw_material_id) {
    window.location.href = "php/add_batch_raw_material.php?raw_material_id=" + raw_material_id;
}

function useRawMaterials(raw_material_id) {
    window.location.href = "php/use_raw_materials.php?raw_material_id=" + raw_material_id;
}

function toggleBatches(raw_material_id) {
    var batches = document.getElementById("batches-" + raw_material_id);
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
        echo "window.location.href = 'ViewRawMaterial.php?page=$prevPage&per_page=$materialsPerPage';";
    }
    ?>
}

function nextPage() {
    <?php
        $nextPage = $currentPage + 1;
        echo "window.location.href = 'ViewRawMaterial.php?page=$nextPage&per_page=$materialsPerPage';";
    ?>
}

function changePerPage() {
    var perPage = document.getElementById("perPage").value;
    <?php
    echo "window.location.href = 'ViewRawMaterial.php?page=1&per_page=' + perPage;";
    ?>
} 

</script>

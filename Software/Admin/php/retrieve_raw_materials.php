<?php
// Include database connection
include 'db_connection.php';

// Query to fetch raw materials data
$sql = "SELECT * FROM raw_materials";
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

            .raw-material-image {
                max-width: 100px;
                max-height: 100px;
            }

            .status-listed {
                background-color: lightgreen;
            }

            .status-unlisted {
                background-color: lightcoral;
            }

            .btn {
                padding: 5px 10px;
                margin-right: 5px;
                cursor: pointer;
            }

            .btn-delete {
                background-color: #f44336;
                color: white;
            }

            .btn-edit {
                background-color: #4CAF50;
                color: white;
            }

            .btn-list {
                background-color: #2196F3;
                color: white;
            }

            .btn-unlist {
                background-color: #ff9800;
                color: white;
            }

            .btn:hover {
                opacity: 0.8;
            }
        ";
        echo "</style>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["raw_material_id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td>" . $row["total_quantity"] . "</td>";
            echo "<td class='" . getStatusClass($row["status"]) . "'>" . $row["status"] . "</td>"; // Status column
            // Display image as <img> tag
            $imageData = base64_encode($row["image"]); // Convert binary image data to base64
            $src = 'data:image/jpeg;base64,'.$imageData; // Specify image MIME type
            echo "<td><img src='{$src}' alt='Raw Material Image' class='raw-material-image'></td>";
            echo "<td>";
            echo "<button class='btn btn-delete' onclick='deleteRawMaterial(" . $row["raw_material_id"] . ")'>Delete</button>";
            echo "<button class='btn btn-edit' onclick='editRawMaterial(" . $row["raw_material_id"] . ")'>Edit</button>";
            if ($row["status"] == "Listed") {
                echo "<button class='btn btn-unlist' onclick='unlistRawMaterial(" . $row["raw_material_id"] . ")'>Unlist</button>";
            } else {
                echo "<button class='btn btn-list' onclick='listRawMaterial(" . $row["raw_material_id"] . ")'>List</button>";
            }
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No raw materials found</td></tr>";
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
</script>

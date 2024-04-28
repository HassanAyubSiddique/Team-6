<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    .pending {
        background-color: #ffcc00;
        color: #333;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .approved {
        background-color: #4caf50;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .rejected {
        background-color: #ff0000;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .button-container {
        display: flex;
    }

    .button-container button {
        margin-right: 5px;
    }
</style>

<?php
// Include database connection
include 'db_connection.php';

// Query to fetch staff data
$sql = "SELECT * FROM staff";
$result = $conn->query($sql);

// Check for successful execution
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Loop through results and build table rows
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["staff_id"] . "</td>";
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
                echo "<button class='approve-button' onclick='approveStaff(" . $row["staff_id"] . ")'>Approve</button>";
            }

            // Reject button if status is Pending
            if ($row["status"] == "Pending") {
                echo "<button class='reject-button' onclick='rejectStaff(" . $row["staff_id"] . ")'>Reject</button>";
            }

            // Delete button
            echo "<button class='delete-button' onclick='deleteStaff(" . $row["staff_id"] . ")'>Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No staff found</td></tr>"; // Adjusting colspan for the added column
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
<script>
function deleteStaff(staff_id) {
    if (confirm("Are you sure you want to delete this staff member?")) {
        window.location.href = "php/delete_staff.php?staff_id=" + staff_id;
    }
}

function approveStaff(staff_id) {
    if (confirm("Are you sure you want to approve this staff member?")) {
        window.location.href = "php/approve_staff.php?staff_id=" + staff_id;
    }
}

function rejectStaff(staff_id) {
    if (confirm("Are you sure you want to reject this staff member?")) {
        window.location.href = "php/reject_staff.php?staff_id=" + staff_id;
    }
}
</script>

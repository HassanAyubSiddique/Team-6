<?php
// Include database connection
include 'db_connection.php';

// Define variables for pagination and staff per page
$staffPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($currentPage - 1) * $staffPerPage;

// Query to fetch staff data with pagination
$sql = "SELECT * FROM staff LIMIT $start, $staffPerPage";
$result = $conn->query($sql);

echo "<link rel='stylesheet' type='text/css' href='../style.css'>";

// Check for successful execution
if ($result) {
    // Check if any rows were returned
    if ($result->num_rows >= 0) {
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

            // Upgrade button if status is Approved
            if ($row["status"] == "Approved") {
                echo "<button class='upgrade-button' onclick='upgradeStaff(" . $row["staff_id"] . ")'>Upgrade</button>";
            }

            // Delete button
            echo "<button class='delete-button' onclick='deleteStaff(" . $row["staff_id"] . ")'>Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</table>";

        // Pagination controls and Staff per page dropdown
        echo "<div class='pagination'>"; 
        echo "<select id='perPage' onchange='changePerPage()'>";
        $perPageOptions = [10, 20, 50, 100];
        foreach ($perPageOptions as $option) {
            echo "<option value='$option' ";
            if ($option == $staffPerPage) {
                echo "selected";
            }
            echo ">$option</option>";
        }
        echo "</select>"; 
        echo "<button onclick='previousPage()'>Previous</button>";
        echo "<button onclick='nextPage()'>Next</button>";
        echo "</div>";
    } else {
        echo "<p>No staff found</p>";
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

function upgradeStaff(staff_id) {
    if (confirm("Are you sure you want to upgrade this staff member?")) {
        window.location.href = "php/upgrade_staff.php?staff_id=" + staff_id;
    }
}

function previousPage() {
    <?php
    if ($currentPage > 1) {
        $prevPage = $currentPage - 1;
        echo "window.location.href = 'Staff.php?page=$prevPage&per_page=$staffPerPage';";
    }
    ?>
}

function nextPage() {
    <?php
        $nextPage = $currentPage + 1;
        echo "window.location.href = 'Staff.php?page=$nextPage&per_page=$staffPerPage';";
    ?>
}

function changePerPage() {
    var perPage = document.getElementById("perPage").value;
    <?php
    echo "window.location.href = 'Staff.php?page=1&per_page=' + perPage;";
    ?>
} 
</script>

<?php
// Include database connection
include 'db_connection.php';

class StaffRetriever {
    private $conn;
    private $staffPerPage;
    private $currentPage;
    private $start;

    public function __construct($conn, $staffPerPage = 10, $currentPage = 1) {
        $this->conn = $conn;
        $this->staffPerPage = $staffPerPage;
        $this->currentPage = $currentPage;
        $this->start = ($currentPage - 1) * $staffPerPage;
    }

    public function retrieveStaff() {
        $sql = "SELECT * FROM staff LIMIT $this->start, $this->staffPerPage";
        $result = $this->conn->query($sql);

        echo "<link rel='stylesheet' type='text/css' href='../style.css'>";

        if ($result) {
            if ($result->num_rows > 0) { // Changed condition to > 0
                while($row = $result->fetch_assoc()) {
                    $this->displayStaffRow($row);
                }

                $this->displayPaginationControls();
            } else {
                echo "<p>No staff found</p>";
            }
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }

        // Close connection
        $this->conn->close();
    }

    private function displayStaffRow($row) {
        echo "<tr>";
        echo "<td>" . $row["staff_id"] . "</td>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td class='" . strtolower($row["status"]) . "'>" . $row["status"] . "</td>";

        // Displaying image if it's in binary format
        $profilePicture = $row["profile_pic"];
        if ($profilePicture) {
            $imageData = base64_encode($profilePicture);
            $src = 'data:image/jpeg;base64,'.$imageData;
            echo "<td><img src='" . $src . "' alt='" . $row["first_name"] . " " . $row["last_name"] . "' style='max-width: 100px;'></td>";
        } else {
            echo "<td>No image</td>";
        }

        echo "<td>";
        $this->displayActionButton($row);
        echo "</td>";
        echo "</tr>";
    }

    private function displayActionButton($row) {
        if ($row["status"] == "Pending") {
            echo "<button class='approve-button' onclick='approveStaff(" . $row["staff_id"] . ")'>Approve</button>";
            echo "<button class='reject-button' onclick='rejectStaff(" . $row["staff_id"] . ")'>Reject</button>";
        } elseif ($row["status"] == "Approved") {
            echo "<button class='upgrade-button' onclick='upgradeStaff(" . $row["staff_id"] . ")'>Upgrade</button>";
        }
        echo "<button class='delete-button' onclick='deleteStaff(" . $row["staff_id"] . ")'>Delete</button>";
    }

    private function displayPaginationControls() {
        echo "</table>";
        echo "<div class='pagination'>"; 
        echo "<select id='perPage' onchange='changePerPage()'>";
        $perPageOptions = [10, 20, 50, 100];
        foreach ($perPageOptions as $option) {
            echo "<option value='$option' ";
            if ($option == $this->staffPerPage) {
                echo "selected";
            }
            echo ">$option</option>";
        }
        
        echo "</select>"; 
        echo "<button onclick='previousPage()'>Previous</button>";
        echo "<button onclick='nextPage()'>Next</button>";
        echo "</div>";
    }
}

// Check for per_page and page parameters
$staffPerPage = isset($_GET['per_page']) ? $_GET['per_page'] : 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$staffRetriever = new StaffRetriever($conn, $staffPerPage, $currentPage);
$staffRetriever->retrieveStaff();
?>

<script>
// JavaScript functions remain unchanged
</script>


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

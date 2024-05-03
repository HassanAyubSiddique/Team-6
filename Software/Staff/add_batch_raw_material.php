<?php
// Include database connection
include 'db_connection.php';

/**
 * Represents a Raw Material with its details fetched from the database.
 */
class add_batch_raw_material {
    private $rawMaterialId;
    private $rawMaterialDetails;

    /**
     * Constructor to initialize the RawMaterial object with the provided ID.
     * @param int $rawMaterialId The ID of the raw material.
     */
    public function __construct($rawMaterialId) {
        $this->rawMaterialId = $rawMaterialId;
    }

    /**
     * Fetches the details of the raw material from the database.
     * @param mysqli $conn The database connection object.
     */
    public function fetchRawMaterialDetails($conn) {
        // Prepare SQL query to retrieve raw material details based on ID
        $sql = "SELECT * FROM raw_materials WHERE raw_material_id = $this->rawMaterialId";

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if raw material exists
        if ($result->num_rows > 0) {
            // Fetch raw material details
            $this->rawMaterialDetails = $result->fetch_assoc();
        } else {
            // Display error message if raw material not found
            echo "Raw material not found";
            exit();
        }
    }

    /**
     * Gets the details of the raw material.
     * @return array The details of the raw material.
     */
    public function getRawMaterialDetails() {
        return $this->rawMaterialDetails;
    }
}

// Check if raw material ID is provided in the URL
if (isset($_GET['raw_material_id'])) {
    // Retrieve raw material ID from the URL
    $rawMaterialId = $_GET['raw_material_id'];

    // Create RawMaterial object
    $rawMaterial = new add_batch_raw_material($rawMaterialId);

    // Fetch raw material details
    $rawMaterial->fetchRawMaterialDetails($conn);
} else {
    // Display error message if raw material ID is not provided
    echo "Raw material ID not provided";
    exit();
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Batch</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add Batch</h2>
        <form action="./update_batch_raw_material.php" method="post" onsubmit="return validateForm()">
            <!-- Hidden input field to pass raw material ID -->
            <input type="hidden" id="raw_material_id" name="raw_material_id" value="<?php echo $rawMaterialId; ?>">
            <div class="form-group">
                <label for="bbd">Best Before Date:</label>
                <input type="date" id="bbd" name="bbd" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <button type="submit">Add Batch</button>
            <!-- Form to close the page without submitting -->
            <form action="/php/ViewRawMaterials.php" method="get">
                <button type="submit" class="close-button">Close</button>
            </form>
        </form>
    </div>
    <script>
        // Function to cancel form submission and go back
        function cancel() {
            window.history.back();
        }

        // Function to validate form data before submission
        function validateForm() {
            var bbd = document.getElementById("bbd").value;
            var quantity = document.getElementById("quantity").value;

            // Get tomorrow's date
            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);

            // Get date 4 years from now
            var fourYearsLater = new Date();
            fourYearsLater.setFullYear(fourYearsLater.getFullYear() + 4);

            // Convert input date to Date object
            var inputDate = new Date(bbd);

            // Validate Best Before Date
            if (inputDate < tomorrow || inputDate > fourYearsLater) {
                alert("Please select a Best Before Date that is tomorrow or later and less than 4 years from now.");
                return false;
            }

            // Validate Quantity
            if (quantity <= 0) {
                alert("Quantity must be greater than 0.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>

<?php
// Include database connection
include 'db_connection.php';

// Get raw material ID from the URL
if (isset($_GET['raw_material_id'])) {
    $raw_material_id = $_GET['raw_material_id'];

    // Retrieve raw material details based on the raw material ID
    $sql_raw_material = "SELECT * FROM raw_materials WHERE raw_material_id = $raw_material_id";
    $result_raw_material = $conn->query($sql_raw_material);

    // Check if raw material exists
    if ($result_raw_material->num_rows > 0) {
        $row_raw_material = $result_raw_material->fetch_assoc();
    } else {
        echo "Raw material not found";
        exit();
    }
} else {
    echo "Raw material ID not provided";
    exit();
}

// Close connection
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
            <input type="hidden" id="raw_material_id" name="raw_material_id" value="<?php echo $raw_material_id; ?>">
            <div class="form-group">
                <label for="bbd">Best Before Date:</label>
                <input type="date" id="bbd" name="bbd" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <button type="submit">Add Batch</button>
            <form action="/php/ViewRawMaterials.php" method="get">
            <button type="submit" class="close-button">Close</button>
        </form>
        </form>
    </div>
    <script>
        function cancel() {
            window.history.back();
        }

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

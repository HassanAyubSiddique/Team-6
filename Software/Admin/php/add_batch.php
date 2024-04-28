<?php
// Include database connection
include 'db_connection.php';

// Get product ID from the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve product details based on the product ID
    $sql_product = "SELECT * FROM products WHERE product_id = $product_id";
    $result_product = $conn->query($sql_product);

    // Check if product exists
    if ($result_product->num_rows > 0) {
        $row_product = $result_product->fetch_assoc();
    } else {
        echo "Product not found";
        exit();
    }
} else {
    echo "Product ID not provided";
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
        <form action="./update_batch.php" method="post" onsubmit="return validateForm()">
            <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id; ?>">
            <div class="form-group">
                <label for="bbd">Best Before Date:</label>
                <input type="date" id="bbd" name="bbd" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <button type="submit">Add Batch</button>
            <button type="button" onclick="cancel()">Cancel</button>
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

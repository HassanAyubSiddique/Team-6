<?php
// Include database connection
include 'db_connection.php';

/**
 * Represents a Product with its details fetched from the database.
 */
class Product {
    private $productId;
    private $productDetails;

    /**
     * Constructor to initialize the Product object with the provided ID.
     * @param int $productId The ID of the product.
     */
    public function __construct($productId) {
        $this->productId = $productId;
    }

    /**
     * Fetches the details of the product from the database.
     * @param mysqli $conn The database connection object.
     */
    public function fetchProductDetails($conn) {
        // Prepare SQL query to retrieve product details based on ID
        $sql = "SELECT * FROM products WHERE product_id = $this->productId";

        // Execute SQL query
        $result = $conn->query($sql);

        // Check if product exists
        if ($result->num_rows > 0) {
            // Fetch product details
            $this->productDetails = $result->fetch_assoc();
        } else {
            // Display error message if product not found
            echo "Product not found";
            exit();
        }
    }

    /**
     * Gets the details of the product.
     * @return array The details of the product.
     */
    public function getProductDetails() {
        return $this->productDetails;
    }
}

// Check if product ID is provided in the URL
if (isset($_GET['product_id'])) {
    // Retrieve product ID from the URL
    $productId = $_GET['product_id'];

    // Create Product object
    $product = new Product($productId);

    // Fetch product details
    $product->fetchProductDetails($conn);
} else {
    // Display error message if product ID is not provided
    echo "Product ID not provided";
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
        <form action="./update_batch.php" method="post" onsubmit="return validateForm()">
            <!-- Hidden input field to pass product ID -->
            <input type="hidden" id="product_id" name="product_id" value="<?php echo $productId; ?>">
            <div class="form-group">
                <label for="bbd">Best Before Date:</label>
                <input type="date" id="bbd" name="bbd" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <button type="submit">Add Batch</button>
            <!-- Button to cancel the form submission -->
            <button type="button" onclick="cancel()">Cancel</button>
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

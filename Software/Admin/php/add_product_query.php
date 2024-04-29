<?php
// Include database connection
include 'db_connection.php';

/**
 * Class to handle product operations
 */
class ProductHandler {
    private $conn;

    /**
     * ProductHandler constructor.
     * @param $conn mysqli The database connection object
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Add a new product to the database.
     * @param string $productName The name of the product
     * @param string $productDescription The description of the product
     * @param string $productImage The image of the product
     * @return bool True if the product is added successfully, otherwise false
     */
    public function addProduct($productName, $productDescription, $productImage) {
        // Prepare the SQL statement with placeholders for the parameters
        $sql = "INSERT INTO products (name, description, main_image) VALUES (?, ?, ?)";

        // Create a prepared statement
        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sss", $productName, $productDescription, $productImage);

        // Execute the statement
        $result = $stmt->execute();

        // Close the prepared statement
        $stmt->close();

        return $result;
    }
}

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productImage = file_get_contents($_FILES['product_image']['tmp_name']);

    // Create ProductHandler object
    $productHandler = new ProductHandler($conn);

    // Add product
    if ($productHandler->addProduct($productName, $productDescription, $productImage)) {
        // If execution is successful, redirect to AddProduct.php with success message
        echo "<script>alert('Product added successfully'); window.location.href = '../AddProduct.php';</script>";
    } else {
        // If execution fails, redirect to AddProduct.php with error message
        echo "<script>alert('Error adding product'); window.location.href = '../AddProduct.php';</script>";
    }

    // Close connection
    $conn->close();
} else {
    // If form is not submitted, redirect to AddProduct.php
    header("Location: ../AddProduct.php");
    exit(); // Stop further execution
}
?>

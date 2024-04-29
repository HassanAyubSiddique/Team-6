<?php
// Include database connection
include 'db_connection.php';

class EditProduct {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to fetch product details from the database
    public function fetchProductDetails($productId) {
        if(isset($productId)) {
            $sql = "SELECT * FROM products WHERE product_id = $productId";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row;
            } else {
                return "No product found with the provided ID";
            }
        } else {
            return "Product ID not specified";
        }
    }

    // Function to display the product form
    public function displayProductForm($productId) {
        $productDetails = $this->fetchProductDetails($productId);

        if ($productDetails !== false) {
            $productName = $productDetails["name"];
            $productDescription = $productDetails["description"];

            echo '<input type="hidden" name="product_id" value="' . $productId . '">';
            echo '<label for="name">Name:</label>';
            echo '<input type="text" id="name" name="name" value="' . $productName . '"><br><br>';
            echo '<label for="description">Description:</label><br>';
            echo '<textarea id="description" name="description">' . $productDescription . '</textarea><br><br>';
            echo '<label for="image">Image:</label>';
            echo '<input type="file" id="image" name="image"><br><br>';
            echo '<button type="submit" name="submit">Save Changes</button>';
            echo '<button type="button" onclick="closePopup()">Cancel</button>';
        } else {
            echo $productDetails;
        }
    }
}

// Create an instance of the EditProduct class
$editProduct = new EditProduct($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="popup">
    <div class="popup-content">
      <span class="close" onclick="closePopup()">&times;</span>
      <h2>Edit Product</h2>
      <form action="update_product.php" method="post" enctype="multipart/form-data">
        <?php
        // Call the displayProductForm method of the EditProduct instance
        $editProduct->displayProductForm($_GET['product_id']);
        ?>
      </form>
    </div>
  </div>

  <script>
    function closePopup() {
      window.location.href = "../ViewProduct.php";
    }
  </script>
</body>
</html>

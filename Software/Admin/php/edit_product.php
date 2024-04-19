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
        // Include database connection
        include 'db_connection.php';

        // Check if product_id is set
        if(isset($_GET['product_id'])) {
            // Retrieve product_id
            $productId = $_GET['product_id'];

            // Fetch product details from database
            $sql = "SELECT * FROM products WHERE product_id = $productId";
            $result = $conn->query($sql);

            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Fetch product details
                $row = $result->fetch_assoc();
                $productName = $row["name"];
                $productDescription = $row["description"];
                // Output form fields with actual values
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
                echo "No product found with the provided ID";
            }
        } else {
            echo "Product ID not specified";
        }

        // Close connection
        $conn->close();
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

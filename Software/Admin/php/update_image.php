<?php
// Include database connection
include 'db_connection.php';

class update_image {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Update product image
    public function updateImage($productId, $imageNumber, $newImageData) {
        // Prepare the update query
        $columnName = ($imageNumber === 0) ? 'main_image' : 'image' . $imageNumber;
        $sql = "UPDATE products SET $columnName = ? WHERE product_id = ?";

        // Execute the query
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $newImageData, $productId);

        if ($stmt->execute()) {
            return "Image updated successfully";
        } else {
            return "Error updating image: " . $this->conn->error;
        }
    }
}

// Function to handle form submission for updating image
function handleImageUpdateFormSubmission($conn) {
    if (isset($_POST['submit'])) {
        $imageUpdater = new update_image($conn);

        // Retrieve form data
        $productId = $_POST['product_id'];
        $imageNumber = $_POST['image_number'];

        // Retrieve image data
        $newImageData = $_FILES['newImage']['tmp_name'];

        // Check if an image is uploaded
        if (isset($_FILES['newImage']) && $_FILES['newImage']['size'] > 0) {
            // Read the image file content and convert it to binary
            $newImageBinary = file_get_contents($newImageData);

            // Update image
            $message = $imageUpdater->updateImage($productId, $imageNumber, $newImageBinary);

            // Redirect back to the product images page with appropriate message
            echo "<script>alert('$message');</script>";
            echo "<script>window.location.href = '../product_images.php?product_id=$productId';</script>";
            exit();
        } else {
            echo "No image uploaded.";
        }
    }
}

// Check if form is submitted to update the image
handleImageUpdateFormSubmission($conn);
 
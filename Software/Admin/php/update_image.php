<?php
// Include database connection
include 'db_connection.php';

// Function to update image in the database
function updateImage($productId, $imageNumber, $newImageData, $conn)
{
    // Prepare the update query
    $columnName = ($imageNumber === 0) ? 'main_image' : 'image' . $imageNumber;
    $sql = "UPDATE products SET $columnName = '$newImageData' WHERE product_id = $productId";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Image updated successfully";
    } else {
        echo "Error updating image: " . $conn->error;
    }
}

// Check if form is submitted to update the image
if(isset($_POST['submit'])){
    // Retrieve form data
    $productId = $_POST['product_id'];
    $imageNumber = $_POST['image_number'];

    // Retrieve image data
    $newImageData = $_FILES['newImage']['tmp_name'];

    // Check if an image is uploaded
    if(isset($_FILES['newImage']) && $_FILES['newImage']['size'] > 0) {
        // Read the image file content and convert it to binary
        $newImageBinary = file_get_contents($newImageData);

        // Prepare image data for insertion
        $newImageBlob = $conn->real_escape_string($newImageBinary);

        // Update image
        updateImage($productId, $imageNumber, $newImageBlob, $conn);

        // Redirect back to the product images page
        header("Location: ../product_images.php?product_id=$productId");
        exit();
    } else {
        echo "No image uploaded.";
    }
}
?>

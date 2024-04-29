<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Images</title>
    <!-- Include Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Slick Slider JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <style>
        /* Style for image slider */
        .slick-slide {
            position: relative;
        }

        .slick-slide img {
            max-width: 100%;
            height: auto;
        }

        .image-title {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .thumbnail-slider {
            margin-top: 20px;
            margin-bottom: 50px; /* Adjusted margin for close button */
        }

        .image-container {
            cursor: pointer;
        }

        .hidden {
            display: none;
        }

        /* Style for close button */
        .close-button { 
            bottom: 20px;
            right: 20px;
            background-color: #007bff; /* Blue color */
            color: #fff;
            padding: 10px; /* Changed padding to auto */
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            border: none;
            display: inline-block; /* Set display to inline-block */
        }

        .close-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <!-- Close icon to go back -->
    <div class="close-button" onclick="window.location.href='/Admin/ViewProduct.php'">Close</div>

    <?php
    // Include database connection
    include 'db_connection.php';

    // Function to convert binary data to base64 encoding
    function convertBinaryToBase64($binaryData)
    {
        return base64_encode($binaryData);
    }

    // Function to update image in the database
    function updateImage($productId, $imageNumber, $newImageData, $conn)
    {
        // Determine the column name based on the image number
        if ($imageNumber === '0') {
            $columnName = 'main_image';
        } else if ($imageNumber >= 1 && $imageNumber <= 7) {
            $columnName = 'image' . $imageNumber;
        } else {
            echo "Invalid image number.";
            return;
        }

        // Prepare the update query
        $sql = "UPDATE products SET $columnName = ? WHERE product_id = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param('si', $newImageData, $productId);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to product_images.php with product_id parameter
            echo '<script>window.history.back();</script>';
            exit();
        } else {
            echo "Error updating image: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Use product ID from the URL if provided
    $productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;

    if ($productId) {
        // Fetch images from the database for the given product ID
        $sql = "SELECT main_image, image1, image2, image3, image4, image5, image6, image7 FROM products WHERE product_id = $productId";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo '<div class="thumbnail-slider">';
            for ($i = 0; $i < 8; $i++) {
                $imageKey = ($i === 0) ? 'main_image' : 'image' . $i;
                echo '<div>';
                if (!empty($row[$imageKey])) {
                    $imageData = convertBinaryToBase64($row[$imageKey]);
                    echo '<div class="image-title">' . (($i === 0) ? 'Main Image' : 'Image ' . $i) . '</div>';
                    echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="' . (($i === 0) ? 'Main Image' : 'Image ' . $i) . '" class="image-container" data-product-id="' . $productId . '" data-image-number="' . $i . '">';
                } else {
                    echo '<span class="add-image" data-product-id="' . $productId . '" data-image-number="' . $i . '">' . (($i === 0) ? 'Add Main Image' : 'Add Image ' . ($i)) . '</span>';
                }
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No images found for the product.</p>';
        }

        // Update image in the database if file is uploaded
        // Update image in the database if file is uploaded
if(isset($_FILES['newImage']) && isset($_POST['image_number']) && isset($_POST['product_id'])) {
    $imageNumber = $_POST['image_number'];
    $productId = $_POST['product_id'];

    // Check if file is an image
    $fileName = $_FILES['newImage']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['tif', 'tiff', 'bmp', 'jpeg', 'jpg', 'gif', 'png', 'eps', 'raw'];
    if (!in_array($fileExtension, $allowedExtensions)) {
        echo "<script>alert('Only TIFF, BMP, JPEG, GIF, PNG, EPS, and RAW image files are allowed.');</script>";
    } else {
        // Check file size
        $fileSize = $_FILES['newImage']['size'];
        $maxSize = 16777215; // Maximum size for MEDIUMBLOB
        if ($fileSize > $maxSize) {
            echo "<script>alert('Image size exceeds maximum allowed size.');</script>";
        } else {
            // Read file content
            $newImageData = file_get_contents($_FILES['newImage']['tmp_name']);
            updateImage($productId, $imageNumber, $newImageData, $conn);
        }
    }
}


        // Close database connection
        $conn->close();
    } else {
        echo '<p>Product ID not provided.</p>';
    }
    ?>

    <!-- Hidden input for file upload -->
    <form action="<?php echo $_SERVER['PHP_SELF'] . '?product_id=' . $productId; ?>" method="post" enctype="multipart/form-data" id="imageForm">
        <input type="hidden" name="image_number" id="imageNumber">
        <input type="hidden" name="product_id" id="product_id" value="<?php echo $productId; ?>">
        <input type="file" name="newImage" class="hidden" accept="image/tiff, image/bmp, image/jpeg, image/jpg, image/gif, image/png, image/eps, image/raw" id="imageUpload">
    </form>

    <!-- JavaScript code -->
    <script>
        // Initialize Slick Slider for thumbnail images
        $('.thumbnail-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: false,
            centerMode: true,
            focusOnSelect: true,
            infinite: false,
            responsive: [
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 400,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });

        // Handle double click on image or "Add Image" link
        $('.image-container, .add-image').on('dblclick', function() {
            var imageNumber = $(this).data('image-number');
            $('#imageNumber').val(imageNumber);
            $('#imageUpload').click();
        });

        // Submit form when file is selected
        $('#imageUpload').on('change', function() {
            $('#imageForm').submit();
        });
    </script>
</body>
</html>

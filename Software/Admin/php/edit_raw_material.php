<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Raw Material</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="popup">
    <div class="popup-content">
      <span class="close" onclick="closePopup()">&times;</span>
      <h2>Edit Raw Material</h2>
      <form action="update_raw_material.php" method="post" enctype="multipart/form-data">
        <?php
        // Include database connection
        include 'db_connection.php';

        // Check if raw_material_id is set
        if(isset($_GET['raw_material_id'])) {
            // Retrieve raw_material_id
            $rawMaterialId = $_GET['raw_material_id'];

            // Fetch raw material details from database
            $sql = "SELECT * FROM raw_materials WHERE raw_material_id = $rawMaterialId";
            $result = $conn->query($sql);

            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Fetch raw material details
                $row = $result->fetch_assoc();
                $rawMaterialName = $row["name"];
                $rawMaterialDescription = $row["description"];
                // Output form fields with actual values
                echo '<input type="hidden" name="raw_material_id" value="' . $rawMaterialId . '">';
                echo '<label for="name">Name:</label>';
                echo '<input type="text" id="name" name="name" value="' . $rawMaterialName . '"><br><br>';
                echo '<label for="description">Description:</label><br>';
                echo '<textarea id="description" name="description">' . $rawMaterialDescription . '</textarea><br><br>';
                echo '<label for="image">Image:</label>';
                echo '<input type="file" id="image" name="image"><br><br>';
                echo '<button type="submit" name="submit">Save Changes</button>';
                echo '<button type="button" onclick="closePopup()">Cancel</button>';
            } else {
                echo "No raw material found with the provided ID";
            }
        } else {
            echo "Raw Material ID not specified";
        }

        // Close connection
        $conn->close();
        ?>
      </form>
    </div>
  </div>

  <script>
    function closePopup() {
      window.location.href = "../raw_materials.php";
    }
  </script>

</body>
</html>

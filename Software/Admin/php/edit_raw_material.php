<?php
// Include database connection
include 'db_connection.php';

class EditRawMaterial {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to fetch raw material details from the database
    public function fetchRawMaterialDetails($rawMaterialId) {
        if(isset($rawMaterialId)) {
            $sql = "SELECT * FROM raw_materials WHERE raw_material_id = $rawMaterialId";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row;
            } else {
                return "No raw material found with the provided ID";
            }
        } else {
            return "Raw Material ID not specified";
        }
    }

    // Function to display the raw material form
    public function displayRawMaterialForm($rawMaterialId) {
        $rawMaterialDetails = $this->fetchRawMaterialDetails($rawMaterialId);

        if ($rawMaterialDetails !== false) {
            $rawMaterialName = $rawMaterialDetails["name"];
            $rawMaterialDescription = $rawMaterialDetails["description"];

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
            echo $rawMaterialDetails;
        }
    }
}

// Create an instance of the EditRawMaterial class
$editRawMaterial = new EditRawMaterial($conn);
?>

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
        // Call the displayRawMaterialForm method of the EditRawMaterial instance
        $editRawMaterial->displayRawMaterialForm($_GET['raw_material_id']);
        ?>
      </form>
    </div>
  </div>

  <script>
    function closePopup() {
      window.location.href = "../ViewRawMaterial.php";
    }
  </script>
</body>
</html>

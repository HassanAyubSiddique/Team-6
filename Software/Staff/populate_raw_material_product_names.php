<?php
// Include the database connection file
include 'DatabaseConnection.php';

// SQL query to retrieve raw material product names
$sql = "SELECT rawMaterialProductName FROM your_raw_material_product_table";

// Execute the query
$result = mysqli_query($con, $sql);

// Check if query was successful
if ($result && mysqli_num_rows($result) > 0) {
    // Output each raw material product name as an option in the dropdown menu
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['rawMaterialProductName'] . "'>" . $row['rawMaterialProductName'] . "</option>";
    }
} else {
    echo "<option value='' disabled>No raw material products found</option>";
}

// Close the database connection
mysqli_close($con);
?>

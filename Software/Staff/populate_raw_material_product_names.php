<select id="rawMaterialProductName" name="rawMaterialProductName" required>
    <?php
    // Include the database connection file
    include 'db_connection.php';

    // SQL query to retrieve raw material product names and statuses
    $sql = "SELECT name, status FROM raw_materials";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($result) {
        // Check if any rows were returned
        if (mysqli_num_rows($result) > 0) {
            // Output each raw material product name with its status as an option in the dropdown menu
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['name'] . "'>" . $row['name'] . " (" . $row['status'] . ")</option>";
            }
        } else {
            echo "<option value='' disabled>No raw material products found</option>";
        }
    } else {
        // Display error message if query fails
        echo "<option value='' disabled>Error: " . mysqli_error($conn) . "</option>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</select>

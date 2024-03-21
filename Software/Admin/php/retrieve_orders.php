<?php
// Include database connection
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Orders</title>
    <style>
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #f5f5f5;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        /* Button styles */
        button {
            background-color: #008CBA;
            color: white;
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #005f7f;
        }
    </style>
</head>
<body>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Client ID</th>
            <th>Status</th>
            <th>Created</th>
            <th>Delivery Reference</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Query to fetch purchase orders data
        $sql = "SELECT * FROM orders";
        $result = $conn->query($sql);

        // Check for successful execution
        if ($result) {
            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Loop through results and build table rows
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["order_id"] . "</td>";
                    echo "<td>" . $row["client_id"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>" . $row["created_on"] . "</td>";
                    echo "<td>" . $row["delivery_reference"] . "</td>";
                    echo "<td>";
                    echo "<button onclick='editOrder(" . $row["order_id"] . ")'>Edit</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No purchase orders found</td></tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Error: " . $conn->error . "</td></tr>";
        }

        // Close connection
        $conn->close();
        ?>
    </tbody>
</table>

<script>
    function editOrder(order_id) {
        // Redirect to the edit order page with the order ID
        window.location.href = "./php/edit_order.php?order_id=" + order_id;
    }
</script>

</body>
</html>

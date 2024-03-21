<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management System - Add Raw Material</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <a href="dashboard.php" class="logo">
            <img src="logo.png" alt="Warehouse Logo">
            <span>Warehouse Management System</span>
        </a>
        <div id="menu-toggle" class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        <div class="right-nav">
            <a href="#" id="alerts-link">Alerts (0)</a>
            <button id="logout-btn">Logout</button>
        </div>
    </header>
    <div class="container">
        <nav class="sidebar">
        <div class="profile">
                <?php include './php/retrieve_admin_info.php'; ?>
            </div>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="reports.php">Reports</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="purchase_orders.php">Purchase Orders</a></li>
                <li class="has-dropdown">
                    <a href="#">Raw Materials</a>
                    <ul class="dropdown">
                        <li><a href="raw_materials.php">View Raw Materials</a></li>
                        <li class="active"><a href="add_raw_material.php">Add Raw Material</a></li>
                    </ul>
                </li>
                <li><a href="staff.php">Staff</a></li>
                <li><a href="clients.php">Clients</a></li>
            </ul>
        </nav>
        <main id="content">
            <h2>Add Raw Material</h2>
            <!-- Form to add new raw material -->
            <form id="add-raw-material-form" action="./php/add_raw_material_query.php" method="post" enctype="multipart/form-data">
                <label for="raw-material-name">Raw Material Name:</label>
                <input type="text" id="raw-material-name" name="raw_material_name" required>
                <label for="raw-material-description">Raw Material Description:</label>
                <textarea id="raw-material-description" name="raw_material_description" required></textarea>
                <label for="raw-material-image">Raw Material Image:</label>
                <input type="file" id="raw-material-image" name="raw_material_image" accept="image/*" required>
                <button type="submit" name="submit">Create Raw Material</button>
            </form>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management System - View Raw Materials</title>
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
                        <li class="active"><a href="raw_materials.php">View Raw Materials</a></li>
                        <li><a href="add_raw_material.php">Add Raw Material</a></li>
                    </ul>
                </li>
                <li><a href="staff.php">Staff</a></li>
                <li><a href="clients.php">Clients</a></li>
            </ul>
        </nav>
        <main id="content">
            <h2>View Raw Materials</h2>
            <!-- Raw materials list section -->
            <div id="raw-materials-list">
                <table>
                    <thead>
                        <tr>
                            <th>Raw Material ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Total Quantity</th>
                            <th>Status</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include './php/retrieve_raw_materials.php'; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management System - Clients</title>
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
                <li class="has-dropdown">
                    <a href="#">Products</a>
                    <ul class="dropdown">
                        <li><a href="products.php">View Products</a></li>
                        <li><a href="add_product.php">Add Product</a></li>
                    </ul>
                </li>
                <li><a href="purchase_orders.php">Purchase Orders</a></li>
                <li><a href="raw_materials.php">Raw Materials</a>
                    <ul class="dropdown">
                        <li><a href="raw_materials.php">View Raw Materials</a></li>
                        <li><a href="add_raw_material.php">Add Raw Material</a></li>
                    </ul>
                </li>
                <li><a href="staff.php">Staff</a></li>
                <li class="active"><a href="clients.php">Clients</a></li>
            </ul>
        </nav>
        <main id="content">
            <h2>Clients</h2>
            <!-- Clients list section -->
            <div id="clients-list">
                <table>
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Profile Picture</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include './php/retrieve_clients.php'; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>

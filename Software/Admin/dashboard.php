<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management System</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
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
                <li class="active"><a href="dashboard.php">Dashboard</a></li>
                <li><a href="reports.php">Reports</a></li>
                <li class="has-dropdown"><a href="#">Products</a>
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
                <li><a href="clients.php">Clients</a></li>
            </ul>
        </nav>
        <main id="content">
            <div class="chart-container">
                <h2>Inventory Distribution</h2>
                <canvas id="inventoryChart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Recent Sales Trends</h2>
                <canvas id="salesChart"></canvas>
            </div>
            <div class="chart-container">
                <h2>Low Stock Alerts</h2>
                <canvas id="lowStockChart"></canvas>
            </div>
        </main>
    </div>
</body>
</html>

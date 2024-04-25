<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Management System - Reports</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <a href="dashboard.php" class="logo">
            <img src="logo.png" alt="Warehouse Logo">
            <span>Warehouse Management</span>
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
                <li class="active"><a href="reports.php">Reports</a></li>
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
                <li><a href="clients.php">Clients</a></li>
            </ul>
        </nav>
        <main id="content">
            <h2>Reports</h2>

            <div class="report-section">
                <h3>Products Report</h3>
                <button id="products-report-btn">Generate Report (PDF)</button>
            </div>

            <div class="report-section">
                <h3>Raw Materials Report</h3>
                <button id="raw-materials-report-btn">Generate Report (PDF)</button>
            </div>

            <div class="report-section">
                <h3>Purchase Orders Report</h3>
                <button id="purchase-orders-report-btn">Generate Report (PDF)</button>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
    <script>
        // All reports
        document.getElementById('products-report-btn').addEventListener('click', function() {
            window.location.href = './php/generate_reports.php?report=products';
        });

        document.getElementById('raw-materials-report-btn').addEventListener('click', function() {
            window.location.href = './php/generate_reports.php?report=raw_materials';
        });

        document.getElementById('purchase-orders-report-btn').addEventListener('click', function() {
            window.location.href = './php/generate_reports.php?report=purchase_orders';
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown Sidebar - Tivotal</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>

    <!-- CSS file -->
    <link rel="stylesheet" href="AdminDashboard.css"/>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar close">
    <div class="logo">
        <!-- If you want to add a logo inside the menu -->
        <span class="logo-name"></span>
    </div>

    <ul class="nav-list">
        <li>
          <div class="icon-link">
            <a href="ViewProduct.php">
              <i class="fas fa-box-open"></i>
              <span class="link-name">Products</span>
            </a>
            <i class="fas fa-caret-down arrow"></i>
          </div>

          <ul class="sub-menu">
            <li><a href="#" class="link-name">Products</a></li>
            <li><a href="ViewProduct.php">View Product</a></li>
          </ul>
        </li>

        <li>
          <a href="PurchaseOrder.php">
            <i class="fas fa-shopping-cart"></i>
            <span class="link-name">Purchase Orders</span>
          </a>

          <ul class="sub-menu blank">
            <li><a href="PurchaseOrder.php" class="link-name">Purchase Orders</a></li>
          </ul>
        </li>

        
        <li>
          <div class="icon-link">
            <a href="ViewRawMaterial.php">
              <i class="fas fa-boxes"></i>
              <span class="link-name">Raw Materials</span>
            </a>
            <i class="fas fa-caret-down arrow"></i>
          </div>

          <ul class="sub-menu">
            <li><a href="#" class="link-name">Raw Materials</a></li>
            <li><a href="ViewRawMaterial.php">View Raw Materials</a></li>
            <li><a href="StaffOrderRawMaterial.html">Order Raw Materials</a></li>
          </ul>
        </li> 

        <li>
          <a href="AdProfile.php">
            <i class="fas fa-id-card-alt"></i>
            <span class="link-name">Profile</span>
          </a>

          <ul class="sub-menu blank">
            <li><a href="AdProfile.php" class="link-name">Profile</a></li>
          </ul>
        </li>

        <li>
          <a href="#" onclick="confirmSignout()">
              <i class="fas fa-sign-out-alt"></i>
              <span class="link-name">Signout</span>
          </a>
      
          <ul class="sub-menu blank">
              <li><a href="#" onclick="confirmSignout()">Signout</a></li>
          </ul>
      </li>
      

      
      </ul>
</div>

<!-- Main Content -->
<div class="home-section">
    <!-- Topbar -->
    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
                <div class="home-content">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
            <img src="img/Screenshot 2024-03-16 at 01.30.56.png" alt="" class="lo">
            <div class="search">
                
            </div>
            <div class="user">
                <img src="img/Screenshot 2024-03-15 at 19.56.42.png" alt="">
            </div>
        </div>
        
        <div class="product-table-container">
            <h2 class="product-heading">List of Purchase Orders</h2>
            <table class="product-table">
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
                    <?php include './retrieve_orders.php'; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="AdminDashboard.js"></script>
</body>
</html>

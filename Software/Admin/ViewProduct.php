<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown Sidebar - Tivotal</title>

    <!--font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>

    <!--css file-->
    <link rel="stylesheet" href="AdminDashboard.css"/>
    <link rel="stylesheet" href="staff.css"/>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>


<!-- ======================= menu ================== -->
<div class="sidebar close">
    <div class="logo">
        <!-- if we want to add logo inside the menu -->
        <span class="logo-name"></span>
    </div>

    <ul class="nav-list">
        <li>
            <a href="AdminDashboard.HTML">
                <i class="fab fa-microsoft"></i>
                <span class="link-name">Dashboard</span>
            </a>

            <ul class="sub-menu blank">
                <li><a href="AdminDashboard.HTML" class="link-name">Dashboard</a></li>
            </ul>
        </li>

        <li>
            <a href="report.php">
                <i class="fas fa-chart-bar"></i>
                <span class="link-name">Report</span>
            </a>

            <ul class="sub-menu blank">
                <li><a href="report.php" class="link-name">Report</a></li>
            </ul>
        </li>

        <li>
            <div class="icon-link">
                <a href="#">
                    <i class="fas fa-box-open"></i>
                    <span class="link-name">Products</span>
                </a>
                <i class="fas fa-caret-down arrow"></i>
            </div>

            <ul class="sub-menu">
                <li><a href="#" class="link-name">Products</a></li>
                <li><a href="ViewProduct.php">View Product</a></li>
                <li><a href="AddProduct.php">Add Product</a></li>
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
                <a href="#">
                    <i class="fas fa-boxes"></i>
                    <span class="link-name">Raw Materials</span>
                </a>
                <i class="fas fa-caret-down arrow"></i>
            </div>

            <ul class="sub-menu">
                <li><a href="#" class="link-name">Raw Materials</a></li>
                <li><a href="ViewRawMaterial.php">View Raw Materials</a></li>
                <li><a href="AddRawMaterial.php">Add Raw Materials</a></li>
            </ul>
        </li>


        <li>
            <a href="Staff.php">
                <i class="fas fa-users"></i>
                <span class="link-name">Staff</span>
            </a>

            <ul class="sub-menu blank">
                <li><a href="Staff.php" class="link-name">Staff</a></li>
            </ul>
        </li>


        <li>
            <a href="Customer.php">
                <i class="fas fa-handshake"></i>
                <span class="link-name">Customers</span>
            </a>

            <ul class="sub-menu blank">
                <li><a href="Customer.php" class="link-name">Customers</a></li>
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



<div class="home-section">
    <!-- ======================= nav ================== -->
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


                <label>
                    <input type="text" placeholder="Search here">
                    <i class="fas fa-search"></i>

                </label>
            </div>

            <div class="user">
                <img src="img/Screenshot 2024-03-15 at 19.56.42.png" alt="">
            </div>

        </div>
        
        <!-- ============= this is for the  Edit Product ============= -->
        <div id="editModal" class="modal hidden">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 class="product-heading">Edit Product</h2>
                <!-- ======= Edit Product form =========== -->
                <form id="editForm" class="edit-form">
                    <!-- ====== on clicking  Form will auto  fields like  (e.g., for product name, description, quantity, etc.) ========= -->
                    <label for="productName">Product Name:</label>
                    <input type="text" id="productName" name="productName">
                    <label for="productDescription">Product Description:</label>
                    <textarea id="productDescription" name="productDescription"></textarea>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="0">
                    </div>
                    <!-- =======  we add more filed if needed =====  -->
                    <button type="submit">Update</button>
                </form>
            </div>
        </div>

        <!-- =========== this for the table ================ -->
        <div class="product-table-container">
            <h2 class="product-heading">List of Products</h2>
            <table class="product-table">
                <thead>
                    <tr>
                      <th>Product ID</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Total Quantity</th>
                      <th>Status</th>
                      <th>Main Image</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php include './php/retrieve_products.php';?>
                  </tbody>
            </table>
            
        </div>
    
      
    </div>
        </div>
        

  
    </div>

  
</div>




<script src="AdminDashboard.js"></script>

</body>
</html>

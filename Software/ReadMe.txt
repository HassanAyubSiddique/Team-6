Initialising the Application

Importing SQL Database

1. Ensure you have XAMPP installed.
2. Navigate to XAMPP's control panel and go to `Config` for the MySQL service.
3. Find `my.ini` and change `max_packet_allowed` from `1M` to `16M`.
4. Start MyApache MySQL modules.
5. Import the SQL database file `database.sql` using phpMyAdmin. If the file is too large, import tables in the following order:
   - clients
   - staff
   - admin
   - orders
   - products
   - product_batches
   - raw_materials
   - raw_material_batches

Setting Up the Application

1. Move the folders (`admin`, `staff`, `client`) to the `xammp/htdocs` directory.
2. Open a web browser and go to `localhost/Admin/login.php`.
3. Click on the "New Customer" button to create a new account, either as a client or staff member.
4. Navigate to `localhost/Admin/Staff.php` to approve the staff account.
5. Proceed to `localhost/Admin/Customer.php` to approve the client account.
6. Return to `localhost/Admin/login.php`, click on "Existing Customer", and enter the corresponding credentials to access the client and staff portals.

Note: If you encounter issues navigating to the correct portals/pages with the credentials, refer to the file structure and directly navigate to the respective file in the browser.

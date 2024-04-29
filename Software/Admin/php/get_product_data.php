<?php
// Include database connection
include 'db_connection.php';

class ProductDataRetriever {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getProductData() {
        $query = "SELECT name, total_quantity FROM products";
        $result = mysqli_query($this->connection, $query);

        $productData = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $productData[] = $row; // Push each row to the $productData array
        }

        mysqli_close($this->connection);

        return json_encode($productData);
    }
}

// Create an instance of ProductDataRetriever class
$productDataRetriever = new ProductDataRetriever($connection);

// Call getProductData method to fetch product data
echo $productDataRetriever->getProductData();
?>

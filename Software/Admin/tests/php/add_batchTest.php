<?php
// Include the class to test
include '../../php/add_batch.php';

use PHPUnit\Framework\TestCase;

/**
 * Test class for the add_batch class.
 */
class add_batchTest extends TestCase {
    /**
     * Test fetching product details with a valid ID.
     */
    public function testFetchProductDetailsWithValidId() {
        // Create a custom mock for the database connection
        $conn = $this->getMockBuilder(mysqli::class)
                     ->disableOriginalConstructor()
                     ->getMock();

        // Mock query result with a single row
        $mockResult = $this->getMockBuilder(mysqli_result::class)
                           ->disableOriginalConstructor()
                           ->getMock();
        $mockResult->method('fetch_assoc')
                   ->willReturn(['product_id' => 1, 'name' => 'Test Product']);

        // Stub the query method to return the mock result
        $conn->method('query')
             ->willReturn($mockResult);

        // Create a new instance of the class to test
        $addBatch = new add_batch(1);

        // Call the method to test
        $addBatch->fetchProductDetails($conn);

        // Assert that product details are fetched correctly
        $this->assertEquals(['product_id' => 1, 'name' => 'Test Product'], $addBatch->getProductDetails());
    }

    /**
     * Test fetching product details with an invalid ID.
     */
    public function testFetchProductDetailsWithInvalidId() {
        // Create a custom mock for the database connection
        $conn = $this->getMockBuilder(mysqli::class)
                     ->disableOriginalConstructor()
                     ->getMock();

        // Mock query result with no rows
        $mockResult = $this->getMockBuilder(mysqli_result::class)
                           ->disableOriginalConstructor()
                           ->getMock();
        $mockResult->method('num_rows')
                   ->willReturn(0);

        // Stub the query method to return the mock result
        $conn->method('query')
             ->willReturn($mockResult);

        // Create a new instance of the class to test
        $addBatch = new add_batch(999);

        // Call the method to test
        $addBatch->fetchProductDetails($conn);

        // Assert that an error message is displayed
        $this->expectOutputString('Product not found');
    }
}
?>

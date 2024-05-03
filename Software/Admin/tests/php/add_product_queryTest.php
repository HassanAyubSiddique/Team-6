<?php
use PHPUnit\Framework\TestCase;

// Include the class to test
include '../../php/add_product_query.php';

/**
 * Test class for the add_product_query class.
 */
class add_product_queryTest extends TestCase {
    /**
     * Test adding a new product with valid data.
     */
    public function testAddProductWithValidData() {
        // Mock database connection
        $conn = $this->createMock(mysqli::class);

        // Create a new instance of the class to test
        $productHandler = new add_product_query($conn);

        // Stub the prepare method of the connection
        $stmt = $this->createMock(mysqli_stmt::class);
        $conn->expects($this->once())
             ->method('prepare')
             ->willReturn($stmt);

        // Stub the execute method of the prepared statement
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(true);

        // Call the method to test
        $result = $productHandler->addProduct('Test Product', 'Test Description', 'test_image.jpg');

        // Assert that the product is added successfully
        $this->assertTrue($result);
    }

    /**
     * Test adding a new product with invalid data.
     */
    public function testAddProductWithInvalidData() {
        // Mock database connection
        $conn = $this->createMock(mysqli::class);

        // Create a new instance of the class to test
        $productHandler = new add_product_query($conn);

        // Stub the prepare method of the connection
        $stmt = $this->createMock(mysqli_stmt::class);
        $conn->expects($this->once())
             ->method('prepare')
             ->willReturn($stmt);

        // Stub the execute method of the prepared statement
        $stmt->expects($this->once())
             ->method('execute')
             ->willReturn(false);

        // Call the method to test
        $result = $productHandler->addProduct('', '', '');

        // Assert that the product addition fails
        $this->assertFalse($result);
    }
}
?>

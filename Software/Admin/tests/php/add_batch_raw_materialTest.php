<?php
// Include the class to test
include "../../php/add_batch_raw_material.php";
use PHPUnit\Framework\TestCase;

/**
 * Test class for the add_batch_raw_material class.
 */
class add_batch_raw_materialTest extends TestCase {
    /**
     * Test fetching raw material details with a valid ID.
     */
    public function testFetchRawMaterialDetailsWithValidId() {
        // Mock database connection
        $conn = $this->createMock(mysqli::class);

        // Mock query result with a single row
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_assoc')
                   ->willReturn(['raw_material_id' => 1, 'name' => 'Test Raw Material']);

        // Stub the query method to return the mock result
        $conn->method('query')
             ->willReturn($mockResult);

        // Create a new instance of the class to test
        $addBatchRawMaterial = new add_batch_raw_material(1);

        // Call the method to test
        $addBatchRawMaterial->fetchRawMaterialDetails($conn);

        // Assert that raw material details are fetched correctly
        $this->assertEquals(['raw_material_id' => 1, 'name' => 'Test Raw Material'], $addBatchRawMaterial->getRawMaterialDetails());
    }

    /**
     * Test fetching raw material details with an invalid ID.
     */
    public function testFetchRawMaterialDetailsWithInvalidId() {
        // Mock database connection
        $conn = $this->createMock(mysqli::class);
    
        // Mock query result with no rows
        $mockResult = $this->createMock(mysqli_result::class);
        $mockResult->method('fetch_assoc')
                   ->willReturn(null); // Simulating no rows returned
    
        // Stub the query method to return the mock result
        $conn->method('query')
             ->willReturn($mockResult);
    
        // Create a new instance of the class to test
        $addBatchRawMaterial = new add_batch_raw_material(999);
    
        // Call the method to test
        $addBatchRawMaterial->fetchRawMaterialDetails($conn);
    
        // Assert that raw material details are not set
        $this->assertNull($addBatchRawMaterial->getRawMaterialDetails());
    }
    
}
?>

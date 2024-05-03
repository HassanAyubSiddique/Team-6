<?php
use PHPUnit\Framework\TestCase;

// Include the class to test
include '../../php/add_raw_material_query.php';

/**
 * Test class for the add_raw_material_query class.
 */
class add_raw_material_queryTest extends TestCase {
    /**
     * Test adding a new raw material with valid data.
     */
    public function testAddRawMaterialWithValidData() {
        // Mock database connection
        $conn = $this->createMock(mysqli::class);

        // Create a new instance of the class to test
        $rawMaterialHandler = new add_raw_material_query($conn);

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
        $_POST['submit'] = true; // Simulate form submission
        $_POST['raw_material_name'] = 'Test Raw Material';
        $_POST['raw_material_description'] = 'Description of Test Raw Material';
        $_FILES['raw_material_image']['tmp_name'] = 'test_image.jpg'; // Simulate file upload
        ob_start(); // Start output buffering to capture echo output
        $rawMaterialHandler->handleFormSubmission();
        $output = ob_get_clean(); // Capture echo output

        // Assert that the raw material is added successfully
        $this->assertStringContainsString('Raw material added successfully', $output);
    }

    /**
     * Test adding a new raw material with invalid data.
     */
    public function testAddRawMaterialWithInvalidData() {
        // Mock database connection
        $conn = $this->createMock(mysqli::class);

        // Create a new instance of the class to test
        $rawMaterialHandler = new add_raw_material_query($conn);

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
        $_POST['submit'] = true; // Simulate form submission
        ob_start(); // Start output buffering to capture echo output
        $rawMaterialHandler->handleFormSubmission();
        $output = ob_get_clean(); // Capture echo output

        // Assert that the raw material addition fails
        $this->assertStringContainsString('Error adding raw material', $output);
    }

    /**
     * Test handling form submission when form is not submitted.
     */
    public function testHandleFormSubmissionWhenFormNotSubmitted() {
        // Mock database connection
        $conn = $this->createMock(mysqli::class);

        // Create a new instance of the class to test
        $rawMaterialHandler = new add_raw_material_query($conn);

        // Expect redirection to AddRawMaterial.php
        $this->expectOutputString('');
        $rawMaterialHandler->handleFormSubmission();
    }
}
?>

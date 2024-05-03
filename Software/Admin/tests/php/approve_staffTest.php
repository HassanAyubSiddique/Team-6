<?php
use PHPUnit\Framework\TestCase;

// Include the class to test
include '../../php/approve_staff.php';

/**
 * Test class for the approve_staff class.
 */
class approve_staffTest extends TestCase {
    /**
     * Test approving a staff member with valid staff ID.
     */
    public function testApproveStaffMemberWithValidId() {
        // Mock database connection
        $conn = $this->createMock(mysqli::class);

        // Create a new instance of the class to test
        $staffManager = new approve_staff($conn);

        // Stub the query method of the connection
        $conn->expects($this->once())
             ->method('query')
             ->willReturn(true); // Simulate successful query execution

        // Call the method to test
        $_GET['staff_id'] = 1; // Simulate staff ID in URL
        ob_start(); // Start output buffering to capture echo output
        processStaffApproval($conn);
        $output = ob_get_clean(); // Capture echo output

        // Assert that success message is displayed
        $this->assertStringContainsString('Staff member approved successfully!', $output);
    }

    /**
     * Test approving a staff member with invalid staff ID.
     */
    public function testApproveStaffMemberWithInvalidId() {
        // Mock database connection
        $conn = $this->createMock(mysqli::class);

        // Create a new instance of the class to test
        $staffManager = new approve_staff($conn);

        // Stub the query method of the connection
        $conn->expects($this->never()) // Expect no query execution
             ->method('query');

        // Call the method to test
        $_GET['staff_id'] = null; // Simulate no staff ID in URL
        ob_start(); // Start output buffering to capture echo output
        processStaffApproval($conn);
        $output = ob_get_clean(); // Capture echo output

        // Assert that redirect is performed
        $this->assertStringContainsString('Location: ../Staff.php', $output);
    }
}
?>

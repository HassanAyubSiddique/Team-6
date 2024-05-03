<?php
include 'db_connection.php';

class customerlogin {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function loginUser($email, $password) {
        // Check if user exists in admins table
        $userData = $this->getUserData('admins', $email);
        if ($userData && password_verify($password, $userData['password'])) {
            $this->handleAdminLogin($userData);
        }

        // Check if user exists in staff table
        $userData = $this->getUserData('staff', $email);
        if ($userData && password_verify($password, $userData['password'])) {
            $this->handleStaffLogin($userData);
        }

        // Check if user exists in clients table
        $userData = $this->getUserData('clients', $email);
        if ($userData && password_verify($password, $userData['password'])) {
            $this->handleClientLogin($userData);
        }

        // If user doesn't exist in any table or password is incorrect
        $this->handleLoginFailure();
    }

    private function getUserData($table, $email) {
        $sql = "SELECT * FROM $table WHERE email='$email'";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    private function handleAdminLogin($userData) {
        session_start();
        $_SESSION["admin_id"] = $userData["admin_id"];
        header("Location: ../AdminDashboard.HTML");
        exit();
    }

    private function handleStaffLogin($userData) {
        session_start();
        if ($userData['status'] == "Pending") {
            $this->displayMessageAndRedirect('Your account is currently pending. Please wait for approval.');
        } elseif ($userData['status'] == "Rejected") {
            $this->displayMessageAndRedirect('Your account request has been rejected. Please contact admin for assistance.');
        } else {
            $_SESSION["staff_id"] = $userData["staff_id"];
            header("Location: ../../Staff/AdProfile.php");
            exit();
        }
    }

    private function handleClientLogin($userData) {
        session_start();
        if ($userData['status'] == "Pending") {
            $this->displayMessageAndRedirect('Your account is currently pending. Please wait for approval.');
        } elseif ($userData['status'] == "Rejected") {
            $this->displayMessageAndRedirect('Your account request has been rejected. Please contact admin for assistance.');
        } else {
            $_SESSION["client_id"] = $userData["client_id"];
            header("Location: ../../Client/landingpages.php");
            exit();
        }
    }

    private function displayMessageAndRedirect($message) {
        echo "<script>alert('$message')</script>";
        echo "<script>window.location.href='../login.php'</script>";
        exit();
    }

    private function handleLoginFailure() {
        session_start();
        $_SESSION["login_error"] = true;
        echo "<script>alert('Please enter correct login details!')</script>";
        echo "<script>window.location.href='../login.php'</script>";
        exit();
    }
}

// Create an instance of UserAuthentication
$userAuth = new customerlogin($conn);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Attempt to login user
    $userAuth->loginUser($email, $password);
}
?>

<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if user exists in admins table
    $sql = "SELECT * FROM admins WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $hashed_password)) {
            // Admin exists and password matches, store admin ID in session and redirect to admin dashboard
            session_start();
            $_SESSION["admin_id"] = $row["admin_id"];
            header("Location: ../AdminDashboard.HTML");
            exit();
        }
    }

    // Check if user exists in staff table
    $sql = "SELECT * FROM staff WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $status = $row['status'];

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $hashed_password)) {
            if ($status == "Pending") {
                // Staff account is pending, display pending message
                echo "<script>alert('Your account is currently pending. Please wait for approval.')</script>";
                echo "<script>window.location.href='../login.php'</script>";
                exit();
            } elseif ($status == "Rejected") {
                // Staff account is rejected, display rejection message
                echo "<script>alert('Your account request has been rejected. Please contact admin for assistance.')</script>";
                echo "<script>window.location.href='../login.php'</script>";
                exit();
            } else {
                // Staff exists, password matches, and status is approved, store staff ID in session and redirect to staff profile
                session_start();
                $_SESSION["staff_id"] = $row["staff_id"];
                header("Location: ../../Staff/AdProfile.php");
                exit();
            }
        }
    }

    // Check if user exists in clients table
    $sql = "SELECT * FROM clients WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $status = $row['status'];

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $hashed_password)) {
            if ($status == "Pending") {
                // Client account is pending, display pending message
                echo "<script>alert('Your account is currently pending. Please wait for approval.')</script>";
                echo "<script>window.location.href='../login.php'</script>";
                exit();
            } elseif ($status == "Rejected") {
                // Client account is rejected, display rejection message
                echo "<script>alert('Your account request has been rejected. Please contact admin for assistance.')</script>";
                echo "<script>window.location.href='../login.php'</script>";
                exit();
            } else {
                // Client exists, password matches, and status is approved, store client ID in session and redirect to client landing page
                session_start();
                $_SESSION["client_id"] = $row["client_id"];
                header("Location: ../../Client/landingpages.php");
                exit();
            }
        }
    }

    // If user doesn't exist in any table or password is incorrect
    session_start();
    $_SESSION["login_error"] = true;
    echo "<script>alert('Please enter correct login details!')</script>";
    echo "<script>window.location.href='../login.php'</script>";
    exit();
}
?>

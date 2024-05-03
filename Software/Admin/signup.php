<?php
// Include the database connection file
include 'php/db_connection.php';

/**
 * Class responsible for handling user signup process
 */
class UserSignupHandler {
    private $conn;

    /**
     * Constructor to initialize the database connection
     * @param $conn mysqli The database connection object
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Function to handle user signup
     * @param array $userData Array containing user data
     * @return string The redirection URL or error message
     */
    public function signupUser($userData) {
        // Validate form submission
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return "signup.html?error=form_not_submitted";
        }

        // Validate role
        $validRoles = ['client', 'staff'];
        if (!in_array($userData['role'], $validRoles)) {
            return "signup.html?error=invalid_role";
        }

        // Hash the password
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);

        // Determine which table to insert data based on the selected role
        $table = ($userData['role'] == 'client') ? 'clients' : 'staff';

        // Prepare the SQL statement to insert data into the appropriate table
        $query = "INSERT INTO $table (first_name, last_name, email, phone_number, address, city, postcode, country, password) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare and bind parameters
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssssss", $userData['firstName'], $userData['lastName'], $userData['email'], 
            $userData['phoneNumber'], $userData['address'], $userData['city'], $userData['postcode'], 
            $userData['country'], $hashedPassword);

        // Execute the query
        if ($stmt->execute()) {
            // Data inserted successfully, redirect to a success page or login page
            return "signup_success.html";
        } else {
            // Error in insertion
            return "signup.html?error=insertion_failed";
        }
    }
}

// Create a UserSignupHandler object
$signupHandler = new UserSignupHandler($con);

// Retrieve form data
$userData = [
    'firstName' => $_POST['firstName'],
    'lastName' => $_POST['lastName'],
    'email' => $_POST['email'],
    'phoneNumber' => $_POST['phoneNumber'],
    'address' => $_POST['address'],
    'city' => $_POST['city'],
    'postcode' => $_POST['postcode'],
    'country' => $_POST['country'],
    'password' => $_POST['password'],
    'role' => $_POST['role']
];

// Handle user signup
$redirectURL = $signupHandler->signupUser($userData);

// Redirect based on the result of signup process
header("Location: $redirectURL");
exit();
?>

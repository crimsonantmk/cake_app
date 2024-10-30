<?php
// Start the session
session_start();

// Step 1: Capture form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Step 2: Database connection
    $servername = "localhost"; // or your server name
    $db_username = "root"; // your DB username
    $db_password = ""; // your DB password
    $dbname = "cakecity"; // your DB name

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 3: Retrieve user data from the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Bind the username parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Step 4: Fetch the user's row
        $user = $result->fetch_assoc();

        // Step 5: Verify the password using password_verify
        if (password_verify($password, $user['password'])) {
            // Step 6: Set session variables (for keeping the user logged in)
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;

            // Redirect to homepage.html
            header("Location: homepage.html");
            exit;
        } else {
            // Invalid password
            echo "Invalid username or password.";
        }
    } else {
        // Invalid username
        echo "Invalid username or password.";
    }

    // Step 7: Close the connection
    $stmt->close();
    $conn->close();
}
?>
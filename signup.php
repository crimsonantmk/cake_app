<?php
// Step 1: Capture form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Step 2: Validate the form data (optional but recommended)
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Step 3: Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Step 4: Database connection
    $servername = "localhost"; // or your server's name
    $db_username = "root"; // your DB username
    $db_password = ""; // your DB password
    $dbname = "cakecity"; // your DB name

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 5: Insert user data into the database
    $sql = "INSERT INTO users (first_name, last_name, dob, email, username, password) 
            VALUES ('$first_name', '$last_name', '$dob', '$email', '$username', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully. <a href='login.html'>Login here</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Step 6: Close the connection
    $conn->close();
}
?>
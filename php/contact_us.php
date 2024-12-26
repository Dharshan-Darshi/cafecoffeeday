<?php
// Database connection parameters
$servername = "localhost"; // Change if your database server is different
$username = "root"; // Your database username
$password = "Dharshan@123"; // Your database password
$dbname = "Cafeshop"; // Your database name

// Initialize variables for form data
$name = $email = $message = "";
$successMessage = $errorMessage = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Validate the form data
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO ContactUs (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement
        if ($stmt->execute()) {
            $successMessage = "Thank you for your message! We will get back to you soon.";
        } else {
            $errorMessage = "There was an error saving your message. Please try again later.";
        }

        // Close the statement
        $stmt->close();
    } else {
        $errorMessage = "All fields are required.";
    }
}

// Close the connection
$conn->close();
?>
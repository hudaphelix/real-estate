<?php
$host = "localhost";
$user = "root";     // your MySQL username
$pass = "";         // your MySQL password
$db   = "submit_db"; // your NEW database name

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Debug: show received data (for testing)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name    = $_POST['name'] ?? '';
  $email   = $_POST['email'] ?? '';
  $phone   = $_POST['phone'] ?? '';
  $subject = $_POST['subject'] ?? '';
  $message = $_POST['message'] ?? '';

  // Insert into DB
  $sql = "INSERT INTO messages (name, email, phone, subject, message)
          VALUES (?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

  if ($stmt->execute()) {
    echo "✅ Message sent and stored successfully!";
  } else {
    echo "❌ Error: " . $stmt->error;
  }

  $stmt->close();
} else {
  echo "Form not submitted via POST.";
}

$conn->close();
?>

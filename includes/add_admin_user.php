<?php
// // Connect to MySQL
// $host = 'localhost';
// $user = 'root';
// $password = '';
// $database = 'devcyberblog';

// $conn = new mysqli($host, $user, $password, $database);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Input data (you can get this from a form)
// $username = 'kastab';
// $email = 'kastab@gmail.com';
// $plainPassword = 'Admin1234';
// $fullName = 'Kastab Garai';
// $phone = '';
// $userType = 'admin'; // You can also use ENUM or integer roles

// // Hash the password
// $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// // Prepare SQL
// $sql = "INSERT INTO users (username, email, password, full_name, phone, user_type, created_at)
//         VALUES (?, ?, ?, ?, ?, ?, NOW())";

// $stmt = $conn->prepare($sql);
// if (!$stmt) {
//     die("Prepare failed: " . $conn->error);
// }

// // Bind parameters
// $stmt->bind_param(
//     "ssssss",
//     $username,
//     $email,
//     $hashedPassword,
//     $fullName,
//     $phone,
//     $userType
// );

// // Execute
// if ($stmt->execute()) {
//     echo "Admin user created successfully!";
// } else {
//     echo "Error: " . $stmt->error;
// }

// // Close
// $stmt->close();
// $conn->close();
?>

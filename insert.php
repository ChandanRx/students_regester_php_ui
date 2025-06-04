<?php
$host = "localhost";
$user = "root";
$pass = "12345"; // 🔁 Replace with your actual MySQL root password
$dbname = "college";

// Step 1: Connect to MySQL without selecting DB
$conn = new mysqli($host, $user, $pass);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Create DB if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

// Select the DB
$conn->select_db($dbname);

// Step 3: Create table if not exists
$tableSql = "CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  branch VARCHAR(100),
  year INT,
  rollno VARCHAR(50)
)";
$conn->query($tableSql);

// Step 4: Get form data
$name = $_POST['name'];
$branch = $_POST['branch'];
$year = $_POST['year'];
$rollno = $_POST['rollno'];

// Step 5: Insert data
$stmt = $conn->prepare("INSERT INTO students (name, branch, year, rollno) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $name, $branch, $year, $rollno);


if ($stmt->execute()) {
  echo '
  <div style="
    font-family: Poppins, sans-serif;
    max-width: 420px;
    margin: 80px auto;
    padding: 35px 30px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    text-align: center;
  ">
    <h2 style="color: #0072ff; margin-bottom: 25px; font-weight: 600;">✅ Registration Successful!</h2>
    <p style="color: #444; font-size: 16px; font-weight: 500;">
      Thank you <strong>' . htmlspecialchars($name) . '</strong>, your data has been saved.
    </p>
    <a href="index.html" style="
      display: inline-block;
      margin-top: 20px;
      padding: 10px 16px;
      background: linear-gradient(to right, #0072ff, #00c6ff);
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
    ">⬅ Back to Form</a>
  </div>';
} else {
  echo '
  <div style="
    font-family: Poppins, sans-serif;
    max-width: 420px;
    margin: 80px auto;
    padding: 35px 30px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    text-align: center;
  ">
    <h2 style="color: #ff3333; margin-bottom: 25px; font-weight: 600;">❌ Error Occurred</h2>
    <p style="color: #444; font-size: 16px; font-weight: 500;">
      ' . htmlspecialchars($stmt->error) . '
    </p>
    <a href="index.html" style="
      display: inline-block;
      margin-top: 20px;
      padding: 10px 16px;
      background: linear-gradient(to right, #ff5e62, #ff9966);
      color: #fff;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
    ">⬅ Try Again</a>
  </div>';
}



$stmt->close();
$conn->close();
?>



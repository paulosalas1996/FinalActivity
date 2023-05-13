<?php
 // Set headers to allow cross-origin requests
 header('Access-Control-Allow-Origin: *');
 header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
 header('Access-Control-Allow-Headers: Content-Type');
 header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_person";

// Create connection
$conn = new mysqli($servername, $username,$password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get records
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $sql = "SELECT * FROM tbl_person";
  $result = $conn->query($sql);

  $records = array();
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $records[] = $row;
    }
  }
  
  echo json_encode($records);
}

// Add record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = md5($_POST["password"]);

  $sql = "INSERT INTO tbl_person (username, email, password) VALUES ('$username', '$email', '$password')";
  if ($conn->query($sql) === TRUE) {
    echo "Record added successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Update record
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
  $id = $_GET["id"];
  $newUsername = $_POST["username"];
  $newEmail = $_POST["email"];
  $newPassword = md5($_POST["password"]);

  $sql = "UPDATE tbl_person SET username='$newUsername', email='$newEmail', password='$newPassword' WHERE id=$id";
  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Delete record
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
  $id = $_GET["id"];

  $sql = "DELETE FROM tbl_person ";
  if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();

?>

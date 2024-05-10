<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "root";
$database = "houn_constraction_pty_limited";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form data
$name = $_POST['name'];
$dept = $_POST['dept'];
$tOW = $_POST['tOW'];
$rate = $_POST['rate'];
$strtNo = $_POST['strtNo'];
$strtName = $_POST['strtName'];
$city = $_POST['city'];
$zC = $_POST['zC'];

// Generate random 4-digit password
$password = rand(1000, 9999);

// Prepare and execute the SQL query for employee table
$sql1 = "INSERT INTO employee (name, dept, tOW, rate) VALUES (?, ?, ?, ?)";
$stmt1 = mysqli_prepare($conn, $sql1);
mysqli_stmt_bind_param($stmt1, "sssi", $name, $dept, $tOW, $rate);
mysqli_stmt_execute($stmt1);

// Get the last inserted ID from the employee table
$empId = mysqli_insert_id($conn);

// Prepare and execute the SQL query for address table
$sql2 = "INSERT INTO address (emp_id, strtNo, strtName, city, zC) VALUES (?, ?, ?, ?, ?)";
$stmt2 = mysqli_prepare($conn, $sql2);
mysqli_stmt_bind_param($stmt2, "issss", $empId, $strtNo, $strtName, $city, $zC);
mysqli_stmt_execute($stmt2);

// Prepare and execute the SQL query for password table
$sql3 = "INSERT INTO password (emp_id, password) VALUES (?, ?)";
$stmt3 = mysqli_prepare($conn, $sql3);
mysqli_stmt_bind_param($stmt3, "is", $empId, $password);
mysqli_stmt_execute($stmt3);

// Check for errors during query execution
if (mysqli_stmt_errno($stmt1) || mysqli_stmt_errno($stmt2) || mysqli_stmt_errno($stmt3)) {
    echo "Error: " . mysqli_error($conn);
} else {
    echo "Data inserted successfully!<br>";
    echo "Employee ID: " . $empId . "<br>";
    echo "Password: " . $password;
}

// Close the prepared statements
mysqli_stmt_close($stmt1);
mysqli_stmt_close($stmt2);
mysqli_stmt_close($stmt3);

// Close the database connection
mysqli_close($conn);
?>

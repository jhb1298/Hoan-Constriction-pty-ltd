<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "houn_constraction_pty_limited";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve form data
$id = $_POST['id'];
$pName = $_POST['pName'];
$hour = $_POST['hour'];



// Prepare and execute the SQL query for employee table
$sql1 = "INSERT INTO ft_pt_work_h (project_id, emp_id, num_of_hours) VALUES (?, ?, ?)";
$stmt1 = mysqli_prepare($conn, $sql1);
mysqli_stmt_bind_param($stmt1, "iii", $pName ,$id, $hour);
mysqli_stmt_execute($stmt1);

// Get the last inserted ID from the employee table



// Close the prepared statements
mysqli_stmt_close($stmt1);

// Close the database connection
mysqli_close($conn);
?>

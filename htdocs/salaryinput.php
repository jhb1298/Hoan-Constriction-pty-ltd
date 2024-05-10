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
$type = $_POST['tow'];
$basic = $_POST['basic'];
$al = $_POST['al'];
$de = $_POST['de'];
$date = $_POST['date'];

if($type=='p'){
// Retrieve values from the database
$type_query = "SELECT type_of_work FROM employee WHERE emp_id = ?";
$type_stmt = mysqli_prepare($conn, $type_query);
mysqli_stmt_bind_param($type_stmt, "i", $id);
mysqli_stmt_execute($type_stmt);
mysqli_stmt_bind_result($type_stmt, $type);
mysqli_stmt_fetch($type_stmt);
mysqli_stmt_close($type_stmt);



$rate_query = "SELECT hourly_rate FROM employee WHERE emp_id = ?";
$rate_stmt = mysqli_prepare($conn, $rate_query);
mysqli_stmt_bind_param($rate_stmt, "i", $id);
mysqli_stmt_execute($rate_stmt);
mysqli_stmt_bind_result($rate_stmt, $rate);
mysqli_stmt_fetch($rate_stmt);
mysqli_stmt_close($rate_stmt);




$hours_query = "SELECT num_of_hours FROM ft_pt_work_h WHERE emp_id = ?";
$hours_stmt = mysqli_prepare($conn, $hours_query);
mysqli_stmt_bind_param($hours_stmt, "i", $id);
mysqli_stmt_execute($hours_stmt);
mysqli_stmt_bind_result($hours_stmt, $hours);
mysqli_stmt_fetch($hours_stmt);
mysqli_stmt_close($hours_stmt);


// Calculate basic and net_salary
$basic = $rate * $hours;
$net_salary = $basic + ($basic / 100) * ($al - $de);
}

echo "ID: " . $id . ", Basic: " . $basic . ", Allowance: " . $al . ", Deduction: " . $de . ", Date: " . $date;

// Prepare and execute the SQL query for salary table
$sql1 = "INSERT INTO salary (emp_id, basic, allowance, deduction, net_salary, salary_date) VALUES (?, ?, ?, ?, ?, ?)";
$stmt1 = mysqli_prepare($conn, $sql1);
mysqli_stmt_bind_param($stmt1, "iiidis", $id, $basic, $al, $de, $net_salary, $date);
mysqli_stmt_execute($stmt1);

echo "Error message: " . mysqli_error($conn);

// Close the prepared statement
mysqli_stmt_close($stmt1);

// Close the database connection
mysqli_close($conn);
?>

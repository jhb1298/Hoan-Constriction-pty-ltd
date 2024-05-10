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
$pass = $_POST['pass'];


// Perform the SQL query DISTINCT 
$sql = "SELECT DISTINCT employee.emp_id,employee.emp_name,employee.type_of_work,dept.dept_name,salary.basic,salary.allowance,salary.deduction,salary.net_salary
FROM employee, dept,ft_pt_work_h,pass,project,salary

where employee.emp_id='$id'
and pass.pass= '$pass'
and employee.emp_id=pass.emp_id
and employee.emp_id=salary.emp_id
and employee.dept_id=dept.dept_id";


$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Generate the table HTML
        $tableHTML = '<table>
                        <thead>
                            <tr>
                                <th style="padding: 10px; border: 1px solid black;">Employee ID</th>
                                <th style="padding: 10px; border: 1px solid black;">Employee Name</th>
                                <th style="padding: 10px; border: 1px solid black;">Type of Work</th>
                                <th style="padding: 10px; border: 1px solid black;">Department Name</th>
                                <th style="padding: 10px; border: 1px solid black;">Basic</th>
                                <th style="padding: 10px; border: 1px solid black;">Allowance</th>
                                <th style="padding: 10px; border: 1px solid black;">deduction</th>
                                <th style="padding: 10px; border: 1px solid black;">Net Salary</th>
                            </tr>
                        </thead>
                        <tbody>';
        
        // Loop through the query results and generate table rows
        while ($row = mysqli_fetch_assoc($result)) {
            $tableHTML .= '<tr>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['emp_id'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['emp_name'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['type_of_work'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['dept_name'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['basic'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['allowance'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['deduction'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['net_salary'] . '</td>
                            </tr>';
        }
        
        $tableHTML .= '</tbody></table>';
        
        // Display the table inside a <div> element
        echo '<div style="text-align: center; display: flex; justify-content: center; align-items: center; height: 100vh " id="resultTable">' . $tableHTML . '</div>';
    } else {
        echo 'No results found.';
    }
} else {
    echo 'Error executing the query: ' . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>

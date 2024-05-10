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
$projectName1 = $_POST['pName41'];
$projectName2 = $_POST['pName42'];

// Perform the SQL query DISTINCT 
$sql = "SELECT employee.emp_id, employee.emp_name, p1.project_name AS project1, p2.project_name AS project2
FROM employee
JOIN ft_pt_work_h f1 ON employee.emp_id = f1.emp_id
JOIN project p1 ON f1.project_id = p1.project_id

JOIN ft_pt_work_h f2 ON employee.emp_id = f2.emp_id
JOIN project p2 ON f2.project_id = p2.project_id

WHERE p1.project_name = '$projectName1'
  AND p2.project_name = '$projectName2'";


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
                                <th style="padding: 10px; border: 1px solid black;">Project1</th>
                                <th style="padding: 10px; border: 1px solid black;">Project2</th>
                            </tr>
                        </thead>
                        <tbody>';
        
        // Loop through the query results and generate table rows
        while ($row = mysqli_fetch_assoc($result)) {
            $tableHTML .= '<tr>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['emp_id'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['emp_name'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['project1'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['project2'] . '</td>

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

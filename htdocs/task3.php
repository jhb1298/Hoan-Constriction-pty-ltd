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
$projectLocation = $_POST['pLoc3'];
$deptLocation = $_POST['dLoc3'];


// Perform the SQL query DISTINCT 
$sql = "SELECT employee.emp_id,employee.emp_name,dept.dept_location,project.project_location
        from employee,dept,project,ft_pt_work_h
        
        where ft_pt_work_h.emp_id=employee.emp_id
        and ft_pt_work_h.project_id=project.project_id
        and project.project_location='$projectLocation'
        and dept.dept_location!='$deptLocation'
        and employee.dept_id=dept.dept_id
        
";


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
                                <th style="padding: 10px; border: 1px solid black;">Department Location</th>
                                <th style="padding: 10px; border: 1px solid black;">Project Location</th>
                                
                            </tr>
                        </thead>
                        <tbody>';
        
        // Loop through the query results and generate table rows
        while ($row = mysqli_fetch_assoc($result)) {
            $tableHTML .= '<tr>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['emp_id'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['emp_name'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['dept_location'] . '</td>
                                <td style="padding: 10px; border: 1px solid black;">' . $row['project_location'] . '</td>
                               
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

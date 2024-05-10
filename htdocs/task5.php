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

// Check if the table name is submitted via POST
if (isset($_POST['tableName'])) {
    $tableName = $_POST['tableName'];

    // Perform the SQL query DISTINCT
    $sql = "SELECT employee.emp_id, employee.emp_name, dept.dept_name, employee.type_of_work, salary.basic, salary.allowance, salary.deduction, salary.net_salary
            FROM employee, dept, salary
            WHERE employee.dept_id = dept.dept_id
            AND employee.emp_id = salary.emp_id
            ORDER BY employee.emp_id";

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
                                    <th style="padding: 10px; border: 1px solid black;">Department</th>
                                    <th style="padding: 10px; border: 1px solid black;">Type of Work</th>
                                    <th style="padding: 10px; border: 1px solid black;">Basic</th>
                                    <th style="padding: 10px; border: 1px solid black;">Allowance</th>
                                    <th style="padding: 10px; border: 1px solid black;">Deduction</th>
                                    <th style="padding: 10px; border: 1px solid black;">Net Salary</th>
                                </tr>
                            </thead>
                            <tbody>';

            // Loop through the query results and generate table rows
            while ($row = mysqli_fetch_assoc($result)) {
                $tableHTML .= '<tr>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['emp_id'] . '</td>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['emp_name'] . '</td>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['dept_name'] . '</td>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['type_of_work'] . '</td>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['basic'] . '</td>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['allowance'] . '</td>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['deduction'] . '</td>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['net_salary'] . '</td>
                                </tr>';
            }

            $tableHTML .= '</tbody></table>';

            // Display the table inside a <div> element
            echo '<div style="text-align: center; display: flex; justify-content: center; align-items: center; height: 100vh " id="resultTable">' . $tableHTML . '</div>';

            // Create the view
            $createViewSQL = "CREATE VIEW `$tableName` AS " . $sql;
            mysqli_query($conn, $createViewSQL);
        } else {
            echo 'No results found.';
        }
    } else {
        echo 'Error executing the query: ' . mysqli_error($conn);
    }
} else {
    echo 'No table name provided.';
}

// Close the database connection
mysqli_close($conn);
?>

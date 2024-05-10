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

// Check if the form is submitted and the date values are set
if (isset($_POST['d0']) && isset($_POST['d1'])) {
    // Get the submitted date values
    $d0 = $_POST['d0'];
    $d1 = $_POST['d1'];

    // Perform the SQL query
    $sql = "SELECT employee.emp_id, employee.emp_name, SUM(ft_pt_work_h.num_of_hours) AS Total_Number_of_hour
            FROM employee, ft_pt_work_h
            WHERE employee.emp_id = ft_pt_work_h.emp_id
            AND ft_pt_work_h.date BETWEEN '$d0' AND '$d1'
            GROUP BY employee.emp_id";

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
                                    <th style="padding: 10px; border: 1px solid black;">Total Number of Hours</th>
                                </tr>
                            </thead>
                            <tbody>';

            // Loop through the query results and generate table rows
            while ($row = mysqli_fetch_assoc($result)) {
                $tableHTML .= '<tr>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['emp_id'] . '</td>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['emp_name'] . '</td>
                                    <td style="padding: 10px; border: 1px solid black;">' . $row['Total_Number_of_hour'] . '</td>
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
}

// Close the database connection
mysqli_close($conn);
?>

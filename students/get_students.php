<?php
// Include your database connection file
require_once "../config.php";

$sql = "SELECT * FROM students";
$result = $link->query($sql);

$students = array();

// Check if any data is fetched
if ($result->num_rows > 0) {
    // Loop through each row and add it to the students array
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

// Close the database connection
$link->close();

// Convert the students array to JSON and return it
header('Content-Type: application/json');
echo json_encode($students);

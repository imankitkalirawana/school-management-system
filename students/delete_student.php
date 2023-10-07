<?php
require_once "../config.php";


// Check if the reg_no parameter is present in the POST request
if (isset($_POST['reg_no'])) {
    $reg_no = $_POST['reg_no'];

    // Prepare and execute the SQL query to delete the record with the given reg_no
    $sql = "DELETE FROM students WHERE reg_no = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("s", $reg_no);

    $response = array();

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Record deleted successfully.";
    } else {
        $response['success'] = false;
        $response['message'] = "Error deleting record: " . $link->error;
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $link->close();

    // Send the JSON response back to the client-side script
    header('Content-Type: application/json');
    echo json_encode($response);
}

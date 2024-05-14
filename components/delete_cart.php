<?php
session_start();
include "../components/db_connect.php"; // Assuming this file contains database connection logic

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Prepare a delete statement
    $sql = "DELETE FROM cart WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Records deleted successfully
            echo "Records deleted successfully.";
        } else {
            echo "Error deleting records: " . $conn->error;
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $conn->close();
} else {
    // Handle the case where ID is not provided or request method is not POST
    echo "Invalid request.";
}
?>

<?php


// Create a database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle database errors
function handleDatabaseError($message)
{
    global $conn;
    $error_message = $message . " - Error: " . $conn->error;
    error_log($error_message);
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => $message));
}

// Function to safely execute a SQL query
function executeQuery($sql, $params = array())
{
    global $conn;

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Check for errors in preparing the statement
    if (!$stmt) {
        handleDatabaseError("SQL preparation error");
        return false;
    }

    // Bind parameters if provided
    if (!empty($params)) {
        $paramTypes = "";
        foreach ($params as $param) {
            if (is_int($param)) {
                $paramTypes .= "i"; // Integer
            } elseif (is_float($param)) {
                $paramTypes .= "d"; // Double
            } elseif (is_string($param)) {
                $paramTypes .= "s"; // String
            } else {
                $paramTypes .= "b"; // Blob
            }
        }
        $stmt->bind_param($paramTypes, ...$params);
    }


    // Execute the statement
    if ($stmt->execute()) {
        return $stmt;
    } else {
        handleDatabaseError("SQL execution error");
        return false;
    }
}

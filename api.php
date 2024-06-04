<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'cafe';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Query to select all data from the 'menu' table
$sql = 'SELECT * FROM menu';

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    // If the query failed, print the error message and exit
    die('Query failed: ' . $conn->error);
}

// Array to store the fetched data
$menus = [];

// Check if there are rows returned by the query
if ($result->num_rows > 0) {
    // Loop through each row of the result set and fetch the data
    while ($row = $result->fetch_assoc()) {
        // Add each row to the $menus array
        $menus[] = $row;
    }
} else {
    // If no rows were returned by the query, print a message
    echo 'No data found';
}

// Close the database connection
$conn->close();

// Set the content type header to JSON
header('Content-Type: application/json');

// Encode the $menus array to JSON and echo it
echo json_encode($menus);
?>

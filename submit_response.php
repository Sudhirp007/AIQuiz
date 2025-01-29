<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['error' => 'Invalid input data']);
    exit();
}

// Extract the data
$user_id = $data['user_id'];
$question_id = $data['question_id'];
$selected_answer = $data['selected_answer'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiz_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Insert user response into the database
$sql = "INSERT INTO responses (user_id, question_id, selected_answer) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
    exit();
}

$stmt->bind_param("iis", $user_id, $question_id, $selected_answer);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(['message' => 'Response recorded successfully']);
} else {
    echo json_encode(['error' => 'Error recording response: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
<?php
// Clear any previous output
ob_clean();

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {
    // Database connection
    $servername = "localhost";
    $username = "u350235445_0exbV";
    $password = "Shiva@4321";
    $dbname = "u350235445_8kuJi";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset('utf8mb4');

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Handle user progress
    if (isset($_GET['user_id'])) {
        $user_id = filter_var($_GET['user_id'], FILTER_VALIDATE_INT);
        $stmt = $conn->prepare("SELECT score FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            exit(json_encode(['success' => true, 'score' => $data['score']]));
        }
        throw new Exception("User not found");
    }

    // Get random question
    $stmt = $conn->prepare("SELECT * FROM questions ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("No questions found");
    }

    $row = $result->fetch_assoc();
    $response = [
        'success' => true,
        'data' => [
            'id' => $row['id'],
            'question' => $row['question'],
            'options' => [
                'A' => $row['option_a'],
                'B' => $row['option_b'],
                'C' => $row['option_c'],
                'D' => $row['option_d']
            ]
        ]
    ];

    exit(json_encode($response));

} catch (Exception $e) {
    http_response_code(500);
    exit(json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]));
}
?>

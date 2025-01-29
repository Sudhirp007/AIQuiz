<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// OpenRouter API Key
$api_key = '';

// Get the user's doubt from the POST request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['doubt'])) {
    echo json_encode(['error' => 'Invalid input data']);
    exit();
}

$doubt = $data['doubt'];

// Prepare the API request
$url = 'https://openrouter.ai/api/v1/chat/completions';
$headers = [
    'Authorization: Bearer ' . $api_key,
    'Content-Type: application/json'
];
$body = [
    'model' => 'meta-llama/llama-3.2-3b-instruct:free',
    'messages' => [
        ['role' => 'user', 'content' => $doubt]
    ],
    'max_tokens' => 400
];

// Send the request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Curl error: ' . curl_error($ch)]);
    curl_close($ch);
    exit();
}

curl_close($ch);

// Extract and limit the response
$response_data = json_decode($response, true);

if (!$response_data || !isset($response_data['choices'][0]['message']['content'])) {
    echo json_encode(['error' => 'Invalid API response']);
    exit();
}

$clarification = $response_data['choices'][0]['message']['content'];
$clarification = substr($clarification, 0, 400);

echo json_encode(['response' => $clarification]);
?>
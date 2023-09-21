<?php
function makeHttpRequest($path_url, $method = 'GET', $params = array()) {

    $url = INSTANCE_URL . $path_url;

    $params["user_token"] = FROM_ID;
    // Construct the URL with query parameters for GET requests
    if ($method === 'GET' && !empty($params)) {
        $params['uuid'] = BOT_ID; // Replace with your actual BOT_ID
        $url .= '?' . http_build_query($params);
    } else {
        $url .= '?' . http_build_query(["uuid" => BOT_ID]);
    }

    DebugLogger::dump($url);
    DebugLogger::dump($params);

    // Initialize cURL session
    $ch = curl_init();

    // Set the cURL options
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . API_KEY, // Add your authorization header here
        ),
    );

    // If it's a POST request and parameters are provided, send them as form data
    if ($method === 'POST' && !empty($params)) {
        $options[CURLOPT_POSTFIELDS] = http_build_query($params);
    }

    // Set cURL options
    curl_setopt_array($ch, $options);

    // Execute cURL request and store the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Return the response
    return $response;
}

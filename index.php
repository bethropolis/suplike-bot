<?php
require('load.php');


$bot = new Bot();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $joke = $bot->quote->getRandomQuote();

    if ($joke)  $bot->create->send($joke, "txt");

    echo json_encode($joke);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bot->processPayload();
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Method not allowed'));
}


<?php
class ChatBot
{
    private $endpoint =  "/api/v1/chat/";

    private $bot_id = FROM_ID;

    public function send($message, $to)
    {
        // Prepare the data for the HTTP request
        $data = array(
            'message' => $message,
            'from' => $this->bot_id,
            'to' => $to,
        );
        $response = makeHttpRequest($this->endpoint, 'POST', $data);

        $data = [$message, $to];

        $sql = "INSERT INTO `chat` ( `message`, `user`) VALUES ( ?, ?);";
        executeQuery($sql, $data);

        DebugLogger::dump($response);
    }


    public function load($data)
    {
        DebugLogger::dump($data);

        $user = isset($data->user) ? $data->user : '';
        $item = isset($data->attributes) ? $data->attributes : 0;
        $replyMessage = "Hello, this is a test message from ChatBot.";
        $this->send($replyMessage, $user);
    }
}
?>

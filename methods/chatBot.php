
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
        $message = isset($data->attributes) ? $data->attributes->message : 0;

        $replyMessage = $this->findReplyInDatabase($message);
        $this->send($replyMessage, $user);
    }

    private function findReplyInDatabase($message)
    {
        $message = '%' . $message . '%';
        $sql = "SELECT * FROM `ai-chat` WHERE `message` LIKE ? AND `who_to` = 79 ORDER BY `id` DESC LIMIT 15;";
        $result = executeQuery($sql, array($message)) ?? [];



        DebugLogger::dump($result);
        if (is_array($result)) {
            $randomKey = array_rand($result);
            $id = intval($result[$randomKey]['id']) + 1;
            $sql = "SELECT * FROM `ai-chat` WHERE `id` = ?";
            $result = executeQuery($sql, array($id));

            if (!empty($result[0]['message'])) {
                return $result[0]['message'];
            }
        }

        return "I'm sorry, I don't understand you.";
    }

    public function getReply(string $message = null)
    {
        return $this->findReplyInDatabase($message);
    }
}
?>

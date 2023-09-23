<?php

class commentBot
{

    private string $endpoint = "/api/v1/comment/";
    private $chat;

    public function __construct()
    {
        $this->chat = new ChatBot();
    }

    public function load($data)
    {
        $commentAttribute = $data->attributes->comment;
    
        // Use a regular expression to extract the comment part after the dynamic mention
        preg_match('/@([^ ]+)\s(.*)/', $commentAttribute, $matches);
    
        if (isset($matches[2])) {
            $comment = $matches[2]; // Extracted comment
        } else {
            $comment = ''; // Default if the regex doesn't match
        }
    
        $dataToSend = [
            "post_id" => $data->attributes->post_id,
            "parent_id" => $data->attributes->comment_id,
            "comment" => $this->chat->getReply($comment),
        ];
    
        DebugLogger::dump($dataToSend);
    
        $response = makeHttpRequest($this->endpoint, 'POST', $dataToSend);
    
        DebugLogger::dump($response);
    }
    
}

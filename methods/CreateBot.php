<?php

class CreateBot
{
    private $endpoint =  "/api/v1/post/";

    public function send($content, $type, $repost = false)
    {

        $data = array(
            "content" => $content,
            "type" => $type,
            "repost" => $repost,
        );

        $response = makeHttpRequest($this->endpoint, 'POST', $data);

        $data = [$content, $type];

        $sql = "INSERT INTO `post` ( `content`, `type`) VALUES ( ?, ?);";

        executeQuery($sql, $data);

        DebugLogger::dump($response);
    }
}

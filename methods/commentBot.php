<?php

class commentBot
{

    private string $endpoint = "/api/v1/comment/";
    public function load($data)
    {

        $data = [
            "post_id" => $data->attributes->post_id,
            "parent_id" => $data->attributes->comment_id,
            "comment" => "whats up",
        ];

        $response = makeHttpRequest($this->endpoint, 'POST', $data);

        DebugLogger::dump($response);
    }
}

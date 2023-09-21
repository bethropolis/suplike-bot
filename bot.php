<?php

class Bot
{
    public $joke;
    public $create;

    public function __construct()
    {
        $this->joke = new JokesBot();
        $this->create = new CreateBot();
    }

    public function processPayload()
    {
        $payloadData = json_decode($this->getData());

        if ($payloadData && isset($payloadData->data->type)) {
            $payloadType = $payloadData->data->type;

            // Define the handler class based on the payload type
            $handlerClassName = ucfirst($payloadType) . 'Bot';

            // Check if the handler class exists
            if (class_exists($handlerClassName)) {
                //DebugLogger::dump($handlerClassName);
                
                $handler = new $handlerClassName();
                $handler->load($payloadData->data);
            } else {
                // Handle unsupported payload type
                echo "Unsupported payload type: $payloadType";
            }
        } else {
            // Handle invalid or missing payload data
            echo "Invalid or missing payload data";
        }
    }


    private function getData()
    {
        $http = file_get_contents('php://input');
        DebugLogger::dump($http);
        return $http;
    }
}

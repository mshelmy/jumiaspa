<?php

namespace Src\Controller\Http;

trait Responses
{
    public function successfulResponse()
    {
        $result = $this->index();

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    public static function notFoundResponse()
    {
        header("HTTP/1.1 404 Not Found");
        exit();
    }
}

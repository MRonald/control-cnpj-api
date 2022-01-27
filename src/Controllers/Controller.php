<?php

namespace Mronald\ControlCnpjApi\Controllers;

abstract class Controller
{
    protected function returnAPIResult(array $response, int $statusCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($response);
        die();
    }

    protected function bodyToObject()
    {
        return json_decode(file_get_contents('php://input'));
    }
}

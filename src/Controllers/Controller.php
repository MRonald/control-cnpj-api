<?php

namespace Mronald\ControlCnpjApi\Controllers;

abstract class Controller
{
    protected function returnAPIResult(array $result): void
    {
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    protected function bodyToObject()
    {
        return json_decode(file_get_contents('php://input'));
    }
}

<?php

namespace Mronald\ControlCnpjApi\Controllers;

abstract class Controller
{
    protected function returnResult(array $result): void
    {
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}

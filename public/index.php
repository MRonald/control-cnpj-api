<?php

require __DIR__ . '/../vendor/autoload.php';

use Mronald\ControlCnpjApi\Controllers\CompanyController;

const PREFIX = '/api/v1/companies';

switch ($_SERVER['PATH_INFO']) {
    case PREFIX . '/list':
        $controller = new CompanyController();
        $controller->index();
        break;
    default:
        echo 'Erro 404';
}

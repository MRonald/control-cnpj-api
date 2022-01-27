<?php

require __DIR__ . '/../vendor/autoload.php';

use Mronald\ControlCnpjApi\Controllers\CompanyController;
use Mronald\ControlCnpjApi\Models\CompanyAddress;

const PREFIX = '/api/v1/companies';
$controller = new CompanyController();

switch ($_SERVER['PATH_INFO']) {
    case PREFIX . '/list':
        $controller->index();
        break;
    case PREFIX . '/create':
        $controller->store();
        break;
    case PREFIX . '/edit':
        $controller->update();
        break;
    default:
        echo 'Erro 404';
}

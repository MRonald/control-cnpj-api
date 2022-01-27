<?php

require __DIR__ . '/../vendor/autoload.php';

use Mronald\ControlCnpjApi\Auth\JWTAuth;
use Mronald\ControlCnpjApi\Controllers\CompanyController;

const PREFIX = '/api/v1/companies';

$jwtAuth = new JWTAuth();

if ($_SERVER['PATH_INFO'] === PREFIX . '/login') {
    $jwtAuth->login();
}
echo $_SERVER['PATH_INFO'];
$jwtAuth->testLogin();

$companyController = new CompanyController();

switch ($_SERVER['PATH_INFO']) {
    case PREFIX . '/list':
        $companyController->index();
        break;
    case PREFIX . '/create':
        $companyController->store();
        break;
    case PREFIX . '/edit':
        $companyController->update();
        break;
    case PREFIX . '/delete':
        $companyController->destroy();
        break;
    default:
        echo 'Erro 404';
}

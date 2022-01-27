<?php

require __DIR__ . '/../vendor/autoload.php';

use Mronald\ControlCnpjApi\Controllers\CompanyController;
use Mronald\ControlCnpjApi\Models\Company;

const PREFIX = '/api/v1/companies';
$controller = new CompanyController();

switch ($_SERVER['PATH_INFO']) {
    case PREFIX . '/list':
        $controller->index();
        break;
    case PREFIX . '/create':
        $controller->store();
        break;
    default:
        echo 'Erro 404';
}


// array(22) { ["DOCUMENT_ROOT"]=> string(59) "C:\Users\win\Documents\Projetos-GIT\control-cnpj-api\public" ["REMOTE_ADDR"]=> string(3) "::1" ["REMOTE_PORT"]=> string(5) "63578" ["SERVER_SOFTWARE"]=> string(29) "PHP 7.4.22 Development Server" ["SERVER_PROTOCOL"]=> string(8) "HTTP/1.1" ["SERVER_NAME"]=> string(9) "localhost" ["SERVER_PORT"]=> string(4) "8080" ["REQUEST_URI"]=> string(24) "/api/v1/companies/create" ["REQUEST_METHOD"]=> string(4) "POST" ["SCRIPT_NAME"]=> string(10) "/index.php" ["SCRIPT_FILENAME"]=> string(69) "C:\Users\win\Documents\Projetos-GIT\control-cnpj-api\public\index.php" ["PATH_INFO"]=> string(24) "/api/v1/companies/create" ["PHP_SELF"]=> string(34) "/index.php/api/v1/companies/create" ["HTTP_HOST"]=> string(14) "localhost:8080" ["HTTP_USER_AGENT"]=> string(17) "insomnia/2021.7.2" ["CONTENT_TYPE"]=> string(16) "application/json" ["HTTP_CONTENT_TYPE"]=> string(16) "application/json" ["HTTP_ACCEPT"]=> string(3) "*/*" ["CONTENT_LENGTH"]=> string(3) "596" ["HTTP_CONTENT_LENGTH"]=> string(3) "596" ["REQUEST_TIME_FLOAT"]=> float(1643240668.0672) ["REQUEST_TIME"]=> int(1643240668) }

<?php

namespace Mronald\ControlCnpjApi\Models;

use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;
use Mronald\ControlCnpjApi\Contracts\ModelContract;

abstract class Model extends DataLayer implements ModelContract
{
    protected $connection;

    public function __construct(string $tableName, array $requiredFields, string $primaryKey = 'id', bool $timestamps = false)
    {
        parent::__construct($tableName, $requiredFields, $primaryKey, $timestamps);
        $this->startConnection();
    }

    private function startConnection(): void
    {
        $conn = Connect::getInstance();
        $error = Connect::getError();

        if ($error) {
            $this->failConnection($error);
        }

        $this->connection = $conn;
    }

    private function failConnection($error): void
    {
        echo $error->getMessage();
        die();
    }
}

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

    protected function fetchToArray(?array $fetchData): array
    {
        $result = [];
        if (isset($fetchData)) {
            foreach ($fetchData as $data) {
                $result[] = $data->data();
            }
        }
        return $result;
    }

    public function all(): array
    {
        return $this->fetchToArray($this->find()->fetch(true));
    }

    public function getById(?string $id): ?self
    {
        return $this->findById(intval($id));
    }

    public function getByCpfCnpj(?string $cpfCnpj): ?self
    {
        return $this->find('cpf_cnpj = :dtStr', 'dtStr=' . $cpfCnpj)->fetch(true)[0];
    }
}

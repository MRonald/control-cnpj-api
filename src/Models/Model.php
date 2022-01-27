<?php

namespace Mronald\ControlCnpjApi\Models;

use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;
use Mronald\ControlCnpjApi\Contracts\ModelContract;

abstract class Model extends DataLayer implements ModelContract
{
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

    public function getById(?string $id): ?self
    {
        return $this->findById(intval($id));
    }

    public function getByCpfCnpj(?string $cpfCnpj): ?self
    {
        return $this->find('cpf_cnpj = :dtStr', 'dtStr=' . $cpfCnpj)->fetch(true)[0];
    }

    public function filteredRecords(array $filters): array
    {
        $terms = '';
        $params = '';
        $first = true;
        foreach ($filters as $key => $value) {
            if ($first) {
                $terms .= $key . ' = :' . $key;
                $params .= $key . '=' . $value;
                $first = false;
            } else {
                $terms .= ' AND ' . $key . ' = :' . $key;
                $params .= '&' . $key . '=' . $value;
            }
        }

        $fetchResult =  $this->find($terms, $params)->fetch(true);
        $response = [];
        foreach ($fetchResult as $result) {
            $response[] = $result->data();
        }
        return $response;
    }
}

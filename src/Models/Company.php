<?php

namespace Mronald\ControlCnpjApi\Models;

class Company extends Model
{
    public function __construct()
    {
        parent::__construct('companies', [
            'person_type',
            'contributor_type',
            'register_type',
            'cnpj',
            'state',
            'corporate_name',
            'address_id',
        ]);
    }

    public function all(): array
    {
        $findResult = $this->find()->fetch(true);
        $companies = [];
        foreach ($findResult as $company) {
            $companies[] = $company->data();
        }
        return $companies;
    }
}

<?php

namespace Mronald\ControlCnpjApi\Models;

use stdClass;

class Company extends Model
{
    public function __construct()
    {
        parent::__construct('companies', [
            'person_type',
            'contributor_type',
            'register_type',
            'cpf_cnpj',
            'state',
            'corporate_name'
        ]);
    }

    public function address(): CompanyAddress
    {
        return (new CompanyAddress)
            ->find('company_id = :cId', 'cId=' . $this->id)
            ->fetch(true)[0]
            ?? new CompanyAddress;
    }
}

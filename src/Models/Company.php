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
}

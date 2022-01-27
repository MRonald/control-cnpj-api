<?php

namespace Mronald\ControlCnpjApi\Models;

class CompanyAddress extends Model
{
    public function __construct()
    {
        parent::__construct('company_address', [
            'user_id',
            'zip_code',
            'public_place',
            'district',
            'city',
            'country'
        ]);
    }
}

<?php

namespace Mronald\ControlCnpjApi\Validators;

use Mronald\ControlCnpjApi\Models\CompanyAddress;

class CompanyAddressValidator extends Validator
{
    private CompanyAddress $companyAddress;

    public function __construct(CompanyAddress $companyAddress)
    {
        $this->companyAddress = $companyAddress;
    }

    public function handle(): void
    {
        // Validations
        parent::required($this->companyAddress->zip_code, 'zip_code');
        parent::required($this->companyAddress->public_place, 'public_place');
        parent::required($this->companyAddress->district, 'district');
        parent::required($this->companyAddress->city, 'city');
        parent::required($this->companyAddress->country, 'country');
    }
}

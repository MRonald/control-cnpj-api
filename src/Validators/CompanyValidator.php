<?php

namespace Mronald\ControlCnpjApi\Validators;

use Mronald\ControlCnpjApi\Models\Company;

class CompanyValidator extends Validator
{
    private Company $company;

    public function __construct(Company $company)
    {
        parent::__construct($company);
        $this->company = $company;
    }

    public function validate(): void
    {
        // Validations

        // Requireds
        parent::required($this->company->person_type, 'person_type');
        parent::required($this->company->contributor_type, 'contributor_type');
        parent::required($this->company->register_type, 'register_type');
        parent::required($this->company->cpf_cnpj, 'cpf_cnpj');
        parent::required($this->company->state, 'state');
        parent::required($this->company->corporate_name, 'corporate_name');
        parent::required($this->company->fantasy_name, 'fantasy_name');
        if ($this->company->main_phone == '' || $this->company->main_phone == null) {
            parent::required(
                $this->company->secondary_phone,
                'secondary_phone',
                'is required to provide one of the phone numbers'
            );
        }
        parent::required($this->company->notes, 'notes');

        // Uniques
        parent::unique($this->company->cpf_cnpj, 'cpf_cnpj');
        parent::unique($this->company->email, 'email');
    }
}

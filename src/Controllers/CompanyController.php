<?php

namespace Mronald\ControlCnpjApi\Controllers;

use Mronald\ControlCnpjApi\Models\Company;
use Mronald\ControlCnpjApi\Models\CompanyAddress;

class CompanyController extends Controller
{
    private Company $model;

    public function __construct()
    {
        $this->model = new Company();
    }

    public function index(): void
    {
        $this->returnAPIResult($this->model->all());
    }

    public function store()
    {
        $data = $this->bodyToObject();

        // // Criando e salvando objeto Company
        $company = new Company();
        $company->person_type = $data->person_type;
        $company->contributor_type = $data->contributor_type;
        $company->register_type = $data->register_type;
        $company->cpf_cnpj = $data->cpf_cnpj;
        $company->state = $data->state;
        $company->state_registration = $data->state_registration;
        $company->county_registration = $data->county_registration;
        $company->corporate_name = $data->corporate_name;
        $company->fantasy_name = $data->fantasy_name;
        $company->main_phone = $data->main_phone;
        $company->secondary_phone = $data->secondary_phone;
        $company->email = $data->email;
        $company->notes = $data->notes;
        $company->save();

        // Criando e salvando CompanyAddress
        $companyAddress = new CompanyAddress();
        $companyAddress->user_id = $company->id;
        $companyAddress->zip_code = $data->address->zip_code;
        $companyAddress->public_place = $data->address->public_place;
        $companyAddress->number = $data->address->number;
        $companyAddress->complement = $data->address->complement;
        $companyAddress->district = $data->address->district;
        $companyAddress->city = $data->address->city;
        $companyAddress->country = $data->address->country;
        $companyAddress->save();

        $response = [
            'message' => 'created successfully'
        ];
        $this->returnAPIResult($response);
    }
}

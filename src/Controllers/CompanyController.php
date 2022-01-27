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

        $message = $this->validateRoles($company);
        $response = [
            'status' => 'created successfully',
            'message' => $message,
            'register_id' => $company->id,
        ];

        $this->returnAPIResult($response);
    }

    private function validateRoles(Company $company): string
    {
        $message = '';

        if ($company->state == 'Goiás' && $company->register_type == 'Variante') {
            $message = 'Mandar equipe de campo';
        }

        if (
            $company->state == 'São Paulo' &&
            $company->register_type == 'Variante' &&
            $company->person_type == 'Física'
        ) {
            $message = 'Reavaliar em 2 meses';
        }

        if (
            $company->state == 'Ceará' &&
            $company->register_type == 'Variante' &&
            $company->person_type == 'Física' &&
            !empty($company->notes)
        ) {
            $message = 'Possível violação do tratado Beta';
        }

        if (
            $company->state == 'Tocantins' &&
            $company->register_type == 'Variante' &&
            $company->person_type == 'Física' &&
            !empty($company->notes)
        ) {
            $message = 'Possível violação do tratado Celta';
        }

        if (
            $company->state == 'Amazonas' &&
            $company->register_type == 'Variante' &&
            $company->person_type == 'Física' &&
            !empty($company->notes)
        ) {
            $message = 'Possível violação do tratado Alpha';
        }

        return $message;
    }
}

<?php

namespace Mronald\ControlCnpjApi\Controllers;

use Mronald\ControlCnpjApi\Models\Company;
use Mronald\ControlCnpjApi\Models\CompanyAddress;
use Mronald\ControlCnpjApi\Validators\CompanyAddressValidator;
use Mronald\ControlCnpjApi\Validators\CompanyValidator;

class CompanyController extends Controller
{
    private Company $model;

    public function __construct()
    {
        $this->model = new Company();
    }

    public function index(): void
    {
        $this->returnAPIResult($this->model->filteredRecords($_GET));
    }

    public function store(): void
    {
        $data = $this->bodyToObject();

        // Criando e salvando objeto Company
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

        $companyValidator = new CompanyValidator($company);
        $companyValidator->validate();

        $company->save();

        // Criando e salvando CompanyAddress
        $companyAddress = new CompanyAddress();
        $companyAddress->company_id = $company->id;
        $companyAddress->zip_code = $data->address->zip_code;
        $companyAddress->public_place = $data->address->public_place;
        $companyAddress->number = $data->address->number;
        $companyAddress->complement = $data->address->complement;
        $companyAddress->district = $data->address->district;
        $companyAddress->city = $data->address->city;
        $companyAddress->country = $data->address->country;

        $companyAddressValidator = new CompanyAddressValidator($companyAddress);
        $companyAddressValidator->validate();

        $companyAddress->save();

        $message = $this->validateRoles($company);
        $response = [
            'status' => 'created successfully',
            'message' => $message,
            'register_id' => $company->id,
        ];

        $this->returnAPIResult($response);
    }

    public function update(): void
    {
        $data = $this->bodyToObject();

        $company = $this->model->getById($data->id);

        if (!isset($company)) {
            $company = $this->model->getByCpfCnpj($data->cpf_cnpj);
        }

        if (!isset($company)) {
            $message = [
                'message' => 'register not found',
            ];
            $this->returnAPIResult($message, 404);
        }

        // Editando e salvando Company
        $company->person_type = $data->person_type;
        $company->contributor_type = $data->contributor_type;
        $company->register_type = $data->register_type;
        $company->state = $data->state;
        $company->state_registration = $data->state_registration;
        $company->county_registration = $data->county_registration;
        $company->corporate_name = $data->corporate_name;
        $company->fantasy_name = $data->fantasy_name;
        $company->main_phone = $data->main_phone;
        $company->secondary_phone = $data->secondary_phone;
        $company->email = $data->email;
        $company->notes = $data->notes;

        $companyValidator = new CompanyValidator($company);
        $companyValidator->validate();

        $company->save();

        // Editando e salvando CompanyAddress
        $companyAddress = $company->address();
        $companyAddress->company_id = $company->id;
        $companyAddress->zip_code = $data->address->zip_code;
        $companyAddress->public_place = $data->address->public_place;
        $companyAddress->number = $data->address->number;
        $companyAddress->complement = $data->address->complement;
        $companyAddress->district = $data->address->district;
        $companyAddress->city = $data->address->city;
        $companyAddress->country = $data->address->country;

        $companyAddressValidator = new CompanyAddressValidator($companyAddress);
        $companyAddressValidator->validate();

        $companyAddress->save();

        $message = [
            'message' => 'updated successfully',
        ];
        $this->returnAPIResult($message, 202);
    }

    public function destroy()
    {
        $data = $this->bodyToObject();

        $company = $this->model->getById($data->id);

        if (!isset($company)) {
            $message = [
                'message' => 'register not found',
            ];
            $this->returnAPIResult($message, 404);
        }

        $companyAddress = $company->address();
        $companyAddress->destroy();
        $company->destroy();

        $message = [
            'message' => 'deleted successfully',
        ];
        $this->returnAPIResult($message, 202);
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

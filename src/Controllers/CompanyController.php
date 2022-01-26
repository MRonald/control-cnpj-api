<?php

namespace Mronald\ControlCnpjApi\Controllers;

use Mronald\ControlCnpjApi\Models\Company;

class CompanyController extends Controller
{
    private Company $model;

    public function __construct()
    {
        $this->model = new Company();
    }

    public function index(): void
    {
        $this->returnResult($this->model->all());
    }
}

<?php

namespace Mronald\ControlCnpjApi\Controllers;

class CompanyController
{
    private array $companies;

    public function __construct()
    {
        $this->companies = ['a', 'b'];
    }

    public function index(): void
    {
        var_dump($this->companies);
    }
}

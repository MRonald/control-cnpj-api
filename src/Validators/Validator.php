<?php

namespace Mronald\ControlCnpjApi\Validators;

use Mronald\ControlCnpjApi\Contracts\ValidatorContract;
use Mronald\ControlCnpjApi\Models\Model;

abstract class Validator implements ValidatorContract
{
    private Model $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    protected function required(?string $value, string $fieldName, ?string $customMessage = null): void
    {
        if ($value === '' || $value === null) {
            $this->failValidation($customMessage ?? 'the ' . $fieldName . ' field is required');
        }
    }

    protected function unique(?string $value, string $fieldName, ?string $customMessage = null): void
    {
        if ($value !== '' || $value !== null) {
            $records = $this->model->filteredRecords([$fieldName => $value]);
            if (!empty($records)) {
                $this->failValidation($customMessage ?? 'the ' . $fieldName . ' informed is already registered');
            }
        }
    }

    private function failValidation(string $response): void
    {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode([
            'message' => $response,
        ]);
        die();
    }
}

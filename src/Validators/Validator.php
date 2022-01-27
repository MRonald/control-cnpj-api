<?php

namespace Mronald\ControlCnpjApi\Validators;

use Mronald\ControlCnpjApi\Contracts\ValidatorContract;

abstract class Validator implements ValidatorContract
{
    protected function required(?string $value, string $fieldName, ?string $customMessage = null): void
    {
        if ($value == '' || $value == null) {
            $this->failValidation($customMessage ?? 'O campo ' . $fieldName . ' é obrigatório');
        }
    }

    public function validate(): void
    {
        $this->handle();
    }

    protected function handle(): void
    {
        // Validations
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

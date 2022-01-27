<?php

namespace Mronald\ControlCnpjApi\Auth;

use Exception;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Mronald\ControlCnpjApi\Models\User;
use stdClass;

class JWTAuth
{
    private ?stdClass $body;
    private ?string $token;

    public function __construct()
    {
        $this->body = json_decode(file_get_contents('php://input'));
        $this->token = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        $this->token = str_replace('Bearer ', '', $this->token);
    }

    public function login(): void
    {
        $data = [
            'name' => $this->body->name,
            'email' => $this->body->email,
        ];

        $user = (new User)->filteredRecords($data);

        if (empty($user)) {
            $message = [
                'message' => 'user not found',
            ];
            $this->returnAPIResult($message, 401);
        }

        $message = [
            'message' => 'logged in',
            'token' => JWT::encode([
                'name' => $data['name'],
                'email' => $data['email']
            ], JWT_SECRET_KEY, 'HS256'),
        ];
        $this->returnAPIResult($message);
    }

    public function testLogin(): void
    {
        try {
            JWT::decode($this->token, new Key(JWT_SECRET_KEY, 'HS256'));
        } catch (Exception $e) {
            $message = [
                'message' => 'authentication error',
            ];
            $this->returnAPIResult($message, 401);
        }
    }

    private function returnAPIResult(array $response, int $statusCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($response);
        die();
    }
}

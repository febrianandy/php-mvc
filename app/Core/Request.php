<?php

declare(strict_types=1);

namespace App\Core;

class Request {
    private $data;

    public function __construct() {
        $this->validateContentType();
        $this->validateJsonData();
        $this->data = $this->sanitizeJsonData();
        $this->checkCsrfToken();
    }

    public function getData() {
        return $this->data;
    }
    
    public function get($key, $default = null) {
        $value = $this->data[$key] ?? $default;
        return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
    }

    public function generateCsrfToken() {
        $token = bin2hex(random_bytes(32)); // Generate a random CSRF token
        $_SESSION['csrf_token'] = $token;   // Store it in the session
        return $token;
    }

    public function verifyCsrfToken($token) {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token); // Compare the stored token with the received token
    }

    private function validateContentType() {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (strcasecmp($contentType, 'application/json') !== 0) {
            throw new \InvalidArgumentException('Content-Type must be application/json.');
        }
    }

    private function validateJsonData() {
        $input = file_get_contents('php://input');
        if ($input === false) {
            throw new \RuntimeException('Failed to read request body.');
        }

        $maxAllowedSize = 1024 * 1024; // 1 MB
        if (strlen($input) > $maxAllowedSize) {
            throw new \LengthException('Request entity too large.');
        }

        $this->data = json_decode($input, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON data.');
        }
    }

    private function sanitizeJsonData() {
        $sanitizedData = [];
        foreach ($this->data as $key => $value) {
            if (is_string($value)) {
                $sanitizedData[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            } else {
                $sanitizedData[$key] = $value;
            }
        }
        return $sanitizedData;
    }

    private function checkCsrfToken() {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        if (in_array($requestMethod, ['POST', 'PUT', 'DELETE'], true)) {
            $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            if (!$this->verifyCsrfToken($token)) {
                throw new \RuntimeException('Invalid CSRF token.');
            }
        }
    }
}

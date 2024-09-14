<?php

namespace App\Backoffice\User\Domain\Services;

class PasswordValidator
{
    private const MIN_LENGTH = 8;
    private const MIN_NUMBERS = 1;
    private const MIN_SYMBOLS = 1;
    private const PROHIBITED_SYMBOLS = ['$', '%', '^', '&'];

    public function validateAndHash(string $password): array
    {
        $errors = [];

        if (strlen($password) < self::MIN_LENGTH) {
            $errors[] = "La contraseña debe tener al menos " . self::MIN_LENGTH . " caracteres.";
        }

        if (preg_match_all('/[0-9]/', $password) < self::MIN_NUMBERS) {
            $errors[] = "La contraseña debe contener al menos " . self::MIN_NUMBERS . " número(s).";
        }

        if (preg_match_all('/[\W_]/', $password) < self::MIN_SYMBOLS) {
            $errors[] = "La contraseña debe contener al menos " . self::MIN_SYMBOLS . " símbolo(s).";
        }

        foreach (self::PROHIBITED_SYMBOLS as $symbol) {
            if (strpos($password, $symbol) !== false) {
                $errors[] = "La contraseña no puede contener el símbolo prohibido: '$symbol'.";
            }
        }

        if (empty($errors)) {
            return [
                'success' => true,
                'hash' => $this->hashPassword($password)
            ];
        }

        return [
            'success' => false,
            'errors' => $errors
        ];
    }

    private function hashPassword(string $password): string
    {
        return hash('sha256', $password);
    }
}

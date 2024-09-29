<?php

namespace App\Admin\User\Domain\Service\Validator\NewUserValidator;

use App\Admin\User\Domain\Service\Validator\UserValidator;

class PasswordValidator implements UserValidator
{
    private const MIN_LENGTH = 8;
    private const MIN_NUMBERS = 1;
    private const MIN_SYMBOLS = 1;
    private const PROHIBITED_SYMBOLS = ['$', '%', '^', '&'];

    public function validate(string $customerId, string $name, string $email, string $password, array &$bag): void
    {
        $passwordBag = [];

        if (strlen($password) < self::MIN_LENGTH) {
            $passwordBag[] = "La contraseña debe tener al menos " . self::MIN_LENGTH . " caracteres.";
        }

        if (preg_match_all('/\d/', $password) < self::MIN_NUMBERS) {
            $passwordBag[] = "La contraseña debe contener al menos " . self::MIN_NUMBERS . " número(s).";
        }

        if (preg_match_all('/[\W_]/', $password) < self::MIN_SYMBOLS) {
            $passwordBag[] = "La contraseña debe contener al menos " . self::MIN_SYMBOLS . " símbolo(s).";
        }

        foreach (self::PROHIBITED_SYMBOLS as $symbol) {
            if (str_contains($password, $symbol)) {
                $passwordBag[] = "La contraseña no puede contener el símbolo prohibido: '$symbol'.";
            }
        }

        if (!empty($passwordBag)) {
            $bag['password'] = $passwordBag;
        }
    }
}

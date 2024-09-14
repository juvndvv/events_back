<?php

namespace Tests\Backoffice\User\Domain\Service;

use PHPUnit\Framework\TestCase;
use App\Backoffice\User\Domain\Services\PasswordValidator;

class PasswordValidatorTest extends TestCase
{
    private PasswordValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new PasswordValidator();
    }

    public function testPasswordIsValid()
    {
        $password = 'ValidPass1!';
        $result = $this->validator->validateAndHash($password);

        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('hash', $result);
        $this->assertEquals(hash('sha256', $password), $result['hash']);
    }

    public function testPasswordTooShort()
    {
        $password = 'Short1!';
        $result = $this->validator->validateAndHash($password);

        $this->assertFalse($result['success']);
        $this->assertContains('La contraseña debe tener al menos 8 caracteres.', $result['errors']);
    }

    public function testPasswordWithoutNumber()
    {
        $password = 'NoNumber!';
        $result = $this->validator->validateAndHash($password);

        $this->assertFalse($result['success']);
        $this->assertContains('La contraseña debe contener al menos 1 número(s).', $result['errors']);
    }

    public function testPasswordWithoutSymbol()
    {
        $password = 'NoSymbol1';
        $result = $this->validator->validateAndHash($password);

        $this->assertFalse($result['success']);
        $this->assertContains('La contraseña debe contener al menos 1 símbolo(s).', $result['errors']);
    }

    public function testPasswordWithProhibitedSymbols()
    {
        $password = 'Password1$';
        $result = $this->validator->validateAndHash($password);

        $this->assertFalse($result['success']);
        $this->assertContains("La contraseña no puede contener el símbolo prohibido: '$'.", $result['errors']);
    }

    public function testPasswordWithMultipleErrors()
    {
        $password = 'short';
        $result = $this->validator->validateAndHash($password);

        $this->assertFalse($result['success']);
        $this->assertContains('La contraseña debe tener al menos 8 caracteres.', $result['errors']);
        $this->assertContains('La contraseña debe contener al menos 1 número(s).', $result['errors']);
        $this->assertContains('La contraseña debe contener al menos 1 símbolo(s).', $result['errors']);
    }
}

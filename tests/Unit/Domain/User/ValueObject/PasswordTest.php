<?php

namespace Tests\Unit\Domain\User\ValueObject;

use App\Domain\User\ValueObject\Password;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function testValidPassword()
    {
        $password = new Password('Password123!');
        $this->assertTrue($password->verify('Password123!'));
    }

    public function testPasswordTooShort()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.");
        new Password('short');
    }

    public function testPasswordWithoutUppercase()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.");
        new Password('password123!');
    }

    public function testPasswordWithoutNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.");
        new Password('Password!');
    }

    public function testPasswordWithoutSpecialCharacter()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.");
        new Password('Password123');
    }
}
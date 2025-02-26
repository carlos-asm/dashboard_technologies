<?php

namespace Tests\Unit\Domain\User\ValueObject;

use App\Domain\User\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testValidEmail()
    {
        $email = new Email('john@example.com');
        $this->assertEquals('john@example.com', $email->getValue());
    }

    public function testInvalidEmailFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid email format.");
        new Email('invalid-email');
    }
}
<?php

namespace Tests\Unit\Domain\User\ValueObject;

use App\Domain\User\ValueObject\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testValidName()
    {
        $name = new Name('John Doe');
        $this->assertEquals('John Doe', $name->getValue());
    }

    public function testNameTooShort()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Name must be at least 3 characters long.");
        new Name('Jo');
    }

    public function testNameWithInvalidCharacters()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Name contains invalid characters.");
        new Name('John@Doe');
    }
}
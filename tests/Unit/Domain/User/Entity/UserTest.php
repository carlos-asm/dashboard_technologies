<?php

namespace Tests\Unit\Domain\User\Entity;

use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserCreation()
    {
        $userId = new UserId('123');
        $name = new Name('John Doe');
        $email = new Email('john@example.com');
        $password = new Password('Password123!');

        $user = new User($userId, $name, $email, $password);

        $this->assertEquals($userId, $user->getId());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($password, $user->getPassword());
    }
}
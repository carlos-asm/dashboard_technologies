<?php

namespace App\Domain\User\ValueObject;

class Password
{
    private string $password;

    public function __construct(string $password)
    {
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            throw new \InvalidArgumentException("Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.");
        }
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getValue(): string
    {
        return $this->password;
    }

    public function verify(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}
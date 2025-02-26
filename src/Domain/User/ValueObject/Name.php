<?php

namespace App\Domain\User\ValueObject;
use InvalidArgumentException;

class Name
{
    private string $name;

    public function __construct(string $name)
    {
        $this->validate($name);
        $this->name = $name;
    }

    private function validate(string $name): void
    {
        if (strlen($name) < 3) {
            throw new InvalidArgumentException("Name must be at least 3 characters long.");
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            throw new InvalidArgumentException("Name contains invalid characters.");
        }
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
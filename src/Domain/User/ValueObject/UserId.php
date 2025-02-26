<?php

namespace App\Domain\User\ValueObject;

class UserId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getValue(): string
    {
        return $this->id;
    }
}
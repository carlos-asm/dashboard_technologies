<?php

namespace App\Application\DTO;

use App\Domain\User\Entity\User;

class UserResponseDTO
{
    public string $id;
    public string $name;
    public string $email;
    public string $createdAt;

    public function __construct(User $user)
    {
        $this->id = $user->getId()->getValue();
        $this->name = $user->getName()->getValue();
        $this->email = $user->getEmail()->getValue();
        $this->createdAt = $user->getCreatedAt()->format('Y-m-d H:i:s');
    }
}
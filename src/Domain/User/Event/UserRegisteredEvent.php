<?php

namespace App\Domain\User\Event;

use App\Domain\User\Entity\User;

class UserRegisteredEvent
{
    public const NAME = 'user.registered';

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
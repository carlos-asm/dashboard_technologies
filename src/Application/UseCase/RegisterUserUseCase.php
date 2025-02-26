<?php

namespace App\Application\UseCase;

use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Event\UserRegisteredEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Application\DTO\RegisterUserRequest;
use App\Application\DTO\UserResponseDTO;
use App\Domain\Exception\UserAlreadyExistsException;


class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(UserRepositoryInterface $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserRequest $request): UserResponseDTO
    {
        $email = new Email($request->email); 

        $existingUser = $this->userRepository->findByEmail($email);
        if ($existingUser !== null) {
            throw new UserAlreadyExistsException("El email ya está en uso.");
        }

        $userId = new UserId(uniqid());
        $name = new Name($request->name);
        $password = new Password($request->password);
        
        $user = new User($userId, $name, $email, $password);
        
        $this->userRepository->save($user);

        $event = new UserRegisteredEvent($user);
        $this->eventDispatcher->dispatch($event, UserRegisteredEvent::NAME);

        return new UserResponseDTO($user);
    }
}
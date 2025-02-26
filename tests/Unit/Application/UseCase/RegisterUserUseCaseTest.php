<?php

namespace Tests\Unit\Application\UseCase;

use App\Application\UseCase\RegisterUserUseCase;
use App\Application\DTO\RegisterUserRequest;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Event\UserRegisteredEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class RegisterUserUseCaseTest extends TestCase
{
    private $userRepository;
    private $eventDispatcher;
    private $registerUserUseCase;

    protected function setUp(): void
    {
        // Mock del repositorio de usuarios
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);

        // Mock del event dispatcher
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);

        // Instancia del caso de uso
        $this->registerUserUseCase = new RegisterUserUseCase(
            $this->userRepository,
            $this->eventDispatcher
        );
    }

    public function testRegisterUserSuccessfully()
    {
        // Datos de prueba
        $name = 'John Doe';
        $email = 'john@example.com';
        $password = 'Password123!';

        // Crear el DTO de solicitud
        $registerUserRequest = new RegisterUserRequest($name, $email, $password);

        // Mock del método save del repositorio
        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        // Mock del método dispatch del event dispatcher
        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(UserRegisteredEvent::class), UserRegisteredEvent::NAME);

        // Ejecutar el caso de uso
        $userResponseDTO = $this->registerUserUseCase->execute($registerUserRequest);

        // Verificar que el DTO de respuesta contiene los datos correctos
        $this->assertEquals($name, $userResponseDTO->name);
        $this->assertEquals($email, $userResponseDTO->email);
        $this->assertNotEmpty($userResponseDTO->id);
        $this->assertNotEmpty($userResponseDTO->createdAt);
    }

    public function testRegisterUserWithInvalidEmail()
    {
        // Datos de prueba con email inválido
        $name = 'John Doe';
        $email = 'invalid-email';
        $password = 'Password123!';

        // Crear el DTO de solicitud
        $registerUserRequest = new RegisterUserRequest($name, $email, $password);

        // Verificar que se lanza una excepción
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid email format.");

        // Ejecutar el caso de uso
        $this->registerUserUseCase->execute($registerUserRequest);
    }

    public function testRegisterUserWithWeakPassword()
    {
        // Datos de prueba con contraseña débil
        $name = 'John Doe';
        $email = 'john@example.com';
        $password = 'weak';

        // Crear el DTO de solicitud
        $registerUserRequest = new RegisterUserRequest($name, $email, $password);

        // Verificar que se lanza una excepción
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must be at least 8 characters long, contain at least one uppercase letter, one number, and one special character.");

        // Ejecutar el caso de uso
        $this->registerUserUseCase->execute($registerUserRequest);
    }
}
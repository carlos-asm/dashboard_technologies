<?php
require __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Infrastructure\Controller\RegisterUserController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\Persistence\DoctrineUserRepository;
use App\Application\UseCase\RegisterUserUseCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Infrastructure\Event\UserRegisteredEventHandler;
use App\Domain\User\Event\UserRegisteredEvent;

// Configuración de Doctrine
$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../src'], true, null, null, false);

// Parámetros de conexión a la base de datos
$conn = [
    'driver' => 'pdo_mysql',
    'host' => 'mysql',
    'dbname' => 'project',
    'user' => 'root',
    'password' => 'root',
];

// Crear el EntityManager
$entityManager = EntityManager::create($conn, $config);

// Crear el repositorio
$userRepository = new DoctrineUserRepository($entityManager);

$eventDispatcher = new EventDispatcher();

// Crear el caso de uso
$registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);

$eventHandler = new UserRegisteredEventHandler();
$eventDispatcher->addListener(UserRegisteredEvent::NAME, [$eventHandler, 'onUserRegistered']);

// Crear el controlador
$controller = new RegisterUserController($registerUserUseCase);

// Crear la solicitud HTTP
$request = Request::createFromGlobals();

// Enrutamiento básico
$path = $request->getPathInfo();

switch ($path) {
    case '/register':
        $response = $controller->__invoke($request);
        break;
    default:
        $response = new JsonResponse(['error' => 'Route not found'], 404);
}

// Enviar la respuesta al cliente
$response->send();
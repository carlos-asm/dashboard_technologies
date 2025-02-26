<?php

namespace Tests\Integration\Infrastructure\Persistence;

use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use App\Infrastructure\Persistence\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

class DoctrineUserRepositoryTest extends TestCase
{
    private EntityManager $em;
    private DoctrineUserRepository $repository;

    protected function setUp(): void
    {
        $config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/src'], true, null, null, false);
        $conn = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];
        $this->em = EntityManager::create($conn, $config);
        $this->repository = new DoctrineUserRepository($this->em);
    }

    public function testSaveAndFindUser()
    {
        $userId = new UserId('123');
        $name = new Name('John Doe');
        $email = new Email('john@example.com');
        $password = new Password('Password123!');

        $user = new User($userId, $name, $email, $password);

        $this->repository->save($user);

        $foundUser = $this->repository->findById($userId);

        $this->assertEquals($user, $foundUser);
    }
}
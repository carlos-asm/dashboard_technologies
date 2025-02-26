<?php

namespace App\Domain\User\Entity;

use App\Domain\User\ValueObject\UserId;
use App\Domain\User\ValueObject\Name;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Password;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string") // Usar string para el ID
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private string $id; // Tipo primitivo (string)

    /**
     * @ORM\Column(type="string")
     */
    private string $name; // Tipo primitivo (string)

    /**
     * @ORM\Column(type="string")
     */
    private string $email; // Tipo primitivo (string)

    /**
     * @ORM\Column(type="string")
     */
    private string $password; // Tipo primitivo (string)

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $created_at;

    public function __construct(UserId $id, Name $name, Email $email, Password $password)
    {
        $this->id = $id->getValue(); 
        $this->name = $name->getValue();
        $this->email = $email->getValue();
        $this->password = $password->getValue();
        $this->created_at = new DateTimeImmutable();
    }

    // Getters que devuelven Value Objects
    public function getId(): UserId
    {
        return new UserId($this->id); 
    }

    public function getName(): Name
    {
        return new Name($this->name);
    }

    public function getEmail(): Email
    {
        return new Email($this->email);
    }

    public function getPassword(): Password
    {
        return new Password($this->password);
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->created_at;
    }
}
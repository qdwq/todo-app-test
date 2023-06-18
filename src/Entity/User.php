<?php

/**
 * User entity.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * @ORM\Table(
 *     name="users",
 *     uniqueConstraints={
 *
 *          @ORM\UniqueConstraint(
 *              name="email_idx",
 *              columns={"email"},
 *          )
 *     }
 * )
 *
 * @UniqueEntity(fields={"email"})
 */
class User implements UserInterface
{
    /**
     * Role user.
     *
     * @var string
     */
    public const ROLE_USER = 'ROLE_USER';

    /**
     * Role admin.
     *
     * @var string
     */
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * Primary key.
     *
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     *
     * @ORM\Column(
     *     name="id",
     *     type="integer",
     *     nullable=false,
     *     options={"unsigned"=true},
     * )
     */
    private ?int $id = null;

    /**
     * E-mail.
     *
     * @ORM\Column(
     *     type="string",
     *     length=180,
     *     unique=true,
     * )
     *
     * @Assert\NotBlank
     *
     * @Assert\Email
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $firstName = '';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $lastName = '';

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private ?\DateTime $birthYear = null;

    /**
     * Roles.
     *
     * @ORM\Column(type="json")
     */
    private ?array $roles = [];

    /**
     * The hashed password.
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank
     *
     * @Assert\Type(type="string")
     */
    private ?string $password;

    /**
     * Getter for the Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for the E-mail.
     *
     * @return string|null E-mail
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for the E-mail.
     *
     * @param string $email E-mail
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     *
     * @return string User name
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * Getter for the Roles.
     *
     * @see UserInterface
     *
     * @return array Roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = static::ROLE_USER;

        return array_unique($roles);
    }

    /**
     * Setter for the Roles.
     *
     * @param array $roles Roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Getter for the Password.
     *
     * @return string Password
     *
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * Setter for the Password.
     *
     * @param string $password Password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Getter for the First Name.
     *
     * @return string FirstName
     */
    public function getFirstName(): string
    {
        return (string) $this->firstName;
    }

    /**
     * Setter for the First Name.
     *
     * @param string|null $firstName FirstName
     *
     * @return void FirstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = (string) $firstName;
    }

    /**
     * Getter for Last Name.
     *
     * @return string LastName
     */
    public function getLastName(): string
    {
        return (string) $this->lastName;
    }

    /**
     * Setter for Last Name.
     *
     * @param string|null $lastName LastName
     *
     * @return void LastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = (string) $lastName;
    }

    /**
     * Getter for the Birth Year.
     *
     * @return \DateTime|null BirthYear
     */
    public function getBirthYear(): ?\DateTime
    {
        return $this->birthYear;
    }

    /**
     * Setter for the Birth Year.
     *
     * @param \DateTime|null $birthYear BirthYear
     *
     * @return void BirthYear
     */
    public function setBirthYear(?\DateTime $birthYear): void
    {
        $this->birthYear = $birthYear;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}

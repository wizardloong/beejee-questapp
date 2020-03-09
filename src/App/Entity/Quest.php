<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="quests")
 */
class Quest
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $completed;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $editedByAdmin;

    /**
     * Quest constructor.
     * @param string $username
     * @param string $email
     * @param string $description
     * @param bool $completed
     * @param bool $editedByAdmin
     */
    public function __construct(
        string $username,
        string $email,
        string $description,
        bool $completed = false,
        bool $editedByAdmin = false
    ) {
        $this->username = $username;
        $this->email = $email;
        $this->description = $description;
        $this->completed = $completed;
        $this->editedByAdmin = $editedByAdmin;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * @param bool $completed
     */
    public function setCompleted(bool $completed = true): void
    {
        $this->completed = $completed;
    }

    /**
     * @return bool
     */
    public function isEditedByAdmin(): bool
    {
        return $this->editedByAdmin;
    }

    /**
     * @param bool $editedByAdmin
     */
    public function setEditedByAdmin(bool $editedByAdmin = true): void
    {
        $this->editedByAdmin = $editedByAdmin;
    }
}

<?php

namespace App\Entity\User;

use App\Entity\Followers\Followers;
use App\Repository\User\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

    #[ORM\Column(nullable: false)]
    private \DateTimeImmutable $createAt;

    #[ORM\Column(length: 255, nullable: false)]
    private string $firstName;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: false)]
    private string $nick;

    #[ORM\Column(length: 255, nullable: false)]
    private string $password;

    #[ORM\Column(type: Types::JSON, nullable: false)]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'Follow', targetEntity: Followers::class)]
    private Collection $followers;

    #[ORM\OneToMany(mappedBy: 'Follower', targetEntity: Followers::class)]
    private Collection $FollowedBy;

    public function __construct()
    {
        $this->followers = new ArrayCollection();
        $this->FollowedBy = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreateAt(): \DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): void
    {
        $this->createAt = $createAt;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getNick(): string
    {
        return $this->nick;
    }

    public function setNick(string $nick): void
    {
        $this->nick = $nick;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->nick;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Followers>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(Followers $follower): void
    {
        $this->getFollowers()->add($follower);
    }

    public function removeFollower(Followers $follower): void
    {
        $this->getFollowers()->remove($follower);
    }

    /**
     * @return Collection<int, Followers>
     */
    public function getFollowedBy(): Collection
    {
        return $this->FollowedBy;
    }

    public function addFollowedBy(Followers $followedBy): void
    {
        $this->getFollowedBy()->add($followedBy);
    }

    public function removeFollowedBy(Followers $followedBy): void
    {
        $this->getFollowedBy()->remove($followedBy);
    }

}

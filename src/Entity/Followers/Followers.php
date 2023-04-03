<?php

namespace App\Entity\Followers;

use App\Entity\User\User;
use App\Repository\Followers\FollowersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowersRepository::class)]
class Followers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private \DateTimeInterface $createAt;

    #[ORM\ManyToOne(inversedBy: 'followers')]
    private ?User $Follow = null;

    #[ORM\ManyToOne(inversedBy: 'FollowedBy')]
    private ?User $Follower = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreateAt(): \DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): void
    {
        $this->createAt = $createAt;

    }

    public function getFollow(): ?User
    {
        return $this->Follow;
    }

    public function setFollow(?User $Follow): void
    {
        $this->Follow = $Follow;

    }

    public function getFollower(): ?User
    {
        return $this->Follower;
    }

    public function setFollower(?User $Follower): void
    {
        $this->Follower = $Follower;

    }
}

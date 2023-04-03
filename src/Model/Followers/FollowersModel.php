<?php

namespace App\Model\Followers;

use App\Entity\Followers\Followers;
use App\Entity\User\User;

class FollowersModel
{
    public ?User $Follow = null;
    public ?User $Follower = null;

    public static function createFromEntity(Followers $followers): FollowersModel
    {
        $newFollower = new self();

        $newFollower->Follow = $followers->getFollow();
        $newFollower->Follower = $followers->getFollower();

        return $newFollower;
    }
}
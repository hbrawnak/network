<?php


namespace App\Repository;


use App\Contracts\FollowerRepositoryInterface;
use App\Models\Follower;

class FollowerRepository implements FollowerRepositoryInterface
{

    /**
     * @param string $user_id
     * @param string $source_id
     * @param string $source_type
     * @return Follower
     */
    public function create(string $user_id, string $source_id, int $source_type)
    {
        $follower              = new Follower();
        $follower->user_id     = $user_id;
        $follower->source_id   = $source_id;
        $follower->source_type = $source_type;
        $follower->save();

        return $follower;
    }
}

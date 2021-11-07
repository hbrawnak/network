<?php


namespace App\Repository;


use App\Contracts\FollowerRepositoryInterface;
use App\Models\Follower;

class FollowerRepository implements FollowerRepositoryInterface
{
    private $follower;

    public function __construct(Follower $follower)
    {
        $this->follower = $follower;
    }

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


    /**
     * @param string $user_id
     * @param string $source_id
     * @param int $source_type
     * @return bool
     */
    public function exist(string $user_id, string $source_id, int $source_type): bool
    {
        return $this->follower
            ->where('user_id', $user_id)
            ->where('source_id', $source_id)
            ->where('source_type', $source_type)
            ->exists();
    }
}

<?php


namespace App\Repository;


use App\Contracts\FollowerRepositoryInterface;
use App\Models\Follower;
use Illuminate\Support\Facades\Cache;

class FollowerRepository implements FollowerRepositoryInterface
{
    const TTL_ONE_MINUTE = 60;

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

    /**
     * @param string $user_id
     * @return mixed
     */
    public function following(string $user_id)
    {
        $key = 'users:following:' . $user_id;

        if (!Cache::has($key)) {
            $following = $this->follower->select('source_id')
                ->where('user_id', $user_id)
                ->get()
                ->toArray();

            $following_list = [];
            foreach ($following as $item) {
                $following_list[] = $item['source_id'];
            }

            Cache::add($key, $following_list, self::TTL_ONE_MINUTE);
        }

        return Cache::get($key);
    }
}

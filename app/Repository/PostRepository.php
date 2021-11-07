<?php


namespace App\Repository;


use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class PostRepository implements PostRepositoryInterface
{
    const TTL_ONE_MINUTE = 60;

    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $source_id
     * @param int $source_type
     * @param string $text
     * @return Post
     */
    public function create(string $source_id, int $source_type, string $text)
    {
        $post              = new Post();
        $post->uuid        = Uuid::uuid4()->toString();
        $post->source_id   = $source_id;
        $post->source_type = $source_type;
        $post->text        = $text;
        $post->save();

        return $post;
    }

    public function feed(array $following, string $user_id, int $page, int $limit)
    {
        $key = 'users:feed:' . $user_id . ':' . $page;
        return Cache::remember($key, self::TTL_ONE_MINUTE, function () use ($following, $limit) {
            return $this->db::table('posts')
                ->select('uuid as id', 'text', 'source_id', 'source_type', 'created_at')
                ->whereIn('source_id', $following)
                ->paginate($limit);
        });
    }
}

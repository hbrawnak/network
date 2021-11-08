<?php


namespace App\Repository;


use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cache;

class PostRepository implements PostRepositoryInterface
{
    const TTL_ONE_MINUTE = 60;

    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
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

    public function feed(array $following, string $user_id)
    {
        $key = 'users:feed:' . $user_id;
        return Cache::remember($key, self::TTL_ONE_MINUTE, function () use ($following) {
            return $this->post->select('uuid', 'text', 'source_id', 'source_type', 'created_at')
                ->whereIn('source_id', $following)
                ->orderBy('created_at', 'desc')
                ->get();
        });
    }
}

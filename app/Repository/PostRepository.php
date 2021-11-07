<?php


namespace App\Repository;


use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Ramsey\Uuid\Uuid;

class PostRepository implements PostRepositoryInterface
{

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
}

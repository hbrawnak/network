<?php


namespace App\Contracts;


interface PostRepositoryInterface
{
    public function create(string $source_id, int $source_type, string $text);

    public function feed(array $following, string $user_id, int $page, int $limit);
}

<?php


namespace App\Contracts;


interface FollowerRepositoryInterface
{
    public function create(string $user_id, string $source_id, int $source_type);

    public function exist(string $user_id, string $source_id, int $source_type);

    public function following(string $user_id);
}

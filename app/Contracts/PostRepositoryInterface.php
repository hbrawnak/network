<?php


namespace App\Contracts;


interface PostRepositoryInterface
{
    public function create(string $source_id, int $source_type, string $text);
}

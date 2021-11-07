<?php


namespace App\Contracts;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function create(Request $request);

    public function find(string $id);

    public function findByEmail(string $email);

    public function exist(string $id);
}

<?php


namespace App\Contracts;


use Illuminate\Http\Request;

interface PageRepositoryInterface
{
    public function create(Request $request, string $user);

    public function exist(string $id);

    public function owner(string $id, string $user_id);
}

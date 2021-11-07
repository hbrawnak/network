<?php


namespace App\Contracts;


use Illuminate\Http\Request;

interface PageRepositoryInterface
{
    public function create(Request $request, string $user);
}

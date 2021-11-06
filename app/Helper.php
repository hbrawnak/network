<?php


namespace App;

class Helper
{
    public static function userFormattedResponse($user): array
    {
        return [
            'id' => $user->uuid,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'created_at' => $user->created_at,
        ];
    }
}

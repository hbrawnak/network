<?php


namespace App;

class Helper
{
    /**
     * @param $user
     * @return array
     */
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

    /**
     * @param $page
     * @return array
     */
    public static function pageFormattedResponse($page): array
    {
        return [
            'id' => $page->uuid,
            'user_id' => $page->user_id,
            'name' => $page->name,
            'created_at' => $page->created_at,
        ];
    }
}

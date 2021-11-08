<?php


namespace App;

use Illuminate\Support\Facades\Facade;

class Helper extends Facade
{
    /**
     * @param $user
     * @return array
     */
    public function userFormattedResponse($user): array
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
    public function pageFormattedResponse($page): array
    {
        return [
            'id' => $page->uuid,
            'user_id' => $page->user_id,
            'name' => $page->name,
            'created_at' => $page->created_at,
        ];
    }

    /**
     * @param $feeds
     * @return array
     */
    public function formattedFeed($feeds)
    {
        $feedArr = [];
        foreach ($feeds as $feed) {
            $feedArr[] = [
                'id' => $feed->uuid,
                'text' => $feed->text,
                'created_at' => $feed->created_at,
                'owner' => [
                    'name' => $feed->owner->name
                ]
            ];
        }

        return $feedArr;
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;

class FeedTest extends TestCase
{
    /**
     * @return void
     */
    public function test_feed_api()
    {
        $response = $this->get('/api/person/feed/');

        $response->assertStatus(200);
    }


    public function test_feed_to_get_200_status()
    {
        $response = $this->postJson('/api/auth/login/',
            [
                'email' => 'habib@gmail.com', 'password' => '1234567'
            ]);

        $feed = $this->getJson('/api/person/feed/', [
            'Authorization' => 'Bearer ' . $response['response']['token']
        ]);

        $feed->assertStatus(200);
        $feed->assertJson([
            'error' => false,
            'message' => 'Feed result',
            'response' => []
        ]);
    }


    public function test_feed_with_wrong_token()
    {
        $response = $this->postJson('/api/auth/login/',
            [
                'email' => 'habib@gmail.com', 'password' => '1234567'
            ]);

        $feed = $this->getJson('/api/person/feed/', [
            'Authorization' => 'Bearer ' . Str::random(10)
        ]);

        $feed->assertJson([
            'status' => 'Token is Invalid',
        ]);
    }
}

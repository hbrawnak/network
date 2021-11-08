<?php


namespace Tests\Feature;


use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_user()
    {
        $response = $this->postJson('/api/auth/login',
            [
                'email' => 'habib@gmail.com', 'password' => '1234567'
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'error' => false,
        ]);
    }


    public function test_login_with_wrong_credentials()
    {
        $response = $this->postJson('/api/auth/login',
            [
                'email' => 'habib@gmail.com', 'password' => 'password'
            ]);

        $response->assertStatus(401);
        $response->assertJson([
            'error' => true,
        ]);
    }
}

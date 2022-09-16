<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class Auth2Test extends ApiTestCase
{
    
    protected function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                '_username' => $username,
                '_password' => $password,
            ])
        );

        dump($client->getResponse()->getContent());
        $data = json_decode($client->getResponse()->getContent(), true);

        dump($data);
    }
    
    public function testSomething(): void
    {
        $this->createAuthenticatedClient();
    }
}

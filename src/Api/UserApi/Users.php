<?php

namespace JuniYadi\GitHub\Api\UserApi;

trait Users
{
    public function getUser($username)
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username cannot be empty.');
        }
        if (! preg_match('/^[a-zA-Z0-9-]+$/', $username)) {
            throw new \InvalidArgumentException('Invalid username format.');
        }
        $response = $this->req->get("{$this->baseUrl}/users/{$username}");
        if ($response->failed()) {
            throw new \Exception('Failed to fetch user: '.$response->json()['message']);
        }

        return $response->json();
    }
}
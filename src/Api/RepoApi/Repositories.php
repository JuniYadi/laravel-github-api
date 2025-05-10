<?php

namespace JuniYadi\GitHub\Api\RepoApi;

trait Repositories
{
    /**
     * List repositories for a user.
     *
     * @param  string  $username
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function getRepositories($username, array $options = [])
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('Username cannot be empty.');
        }
        if (! preg_match('/^[a-zA-Z0-9-]+$/', $username)) {
            throw new \InvalidArgumentException('Invalid username format.');
        }
        $defaultOptions = [
            'type' => 'all',
            'sort' => 'full_name',
            'direction' => 'asc',
            'per_page' => 30,
            'page' => 1,
        ];
        $params = array_merge($defaultOptions, array_filter($options));
        $response = $this->req->get("{$this->baseUrl}/users/{$username}/repos", $params);
        if ($response->failed()) {
            throw new \Exception('Failed to fetch repositories: '.$response->json()['message']);
        }

        return $response->json();
    }
}

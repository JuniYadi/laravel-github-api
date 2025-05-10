<?php

namespace JuniYadi\GitHub\Api\RepoApi;

trait Branches
{
    /**
     * List branches for a repository.
     *
     * @param  string  $repo
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function getBranches($repo, array $options = [])
    {
        if (empty($repo)) {
            throw new \InvalidArgumentException('Repository cannot be empty.');
        }
        if (! preg_match('/^[a-zA-Z0-9-]+\/[a-zA-Z0-9-]+$/', $repo)) {
            throw new \InvalidArgumentException('Invalid repository format.');
        }
        $params = array_filter($options);
        $response = $this->req->get("{$this->baseUrl}/repos/{$repo}/branches", $params);
        if ($response->failed()) {
            throw new \Exception('Failed to fetch branches: '.$response->json()['message']);
        }

        return $response->json();
    }
}

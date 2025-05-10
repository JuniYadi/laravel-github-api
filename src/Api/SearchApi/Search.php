<?php

namespace JuniYadi\GitHub\Api\SearchApi;

trait Search
{
    /**
     * Search repositories
     *
     * @param string $query The search query
     * @param array $options Additional options for the search
     * @return array
     */
    public function searchRepositories(string $query, array $options = []): array
    {
        $params = array_merge(['q' => $query], $options);
        $response = $this->req->get('/search/repositories', $params);

        if ($response->failed()) {
            throw new \Exception('Failed to search repositories: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Search code
     *
     * @param string $query The search query
     * @param array $options Additional options for the search
     * @return array
     */
    public function searchCode(string $query, array $options = []): array
    {
        $params = array_merge(['q' => $query], $options);
        $response = $this->req->get('/search/code', $params);

        if ($response->failed()) {
            throw new \Exception('Failed to search code: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Search users
     *
     * @param string $query The search query
     * @param array $options Additional options for the search
     * @return array
     */
    public function searchUsers(string $query, array $options = []): array
    {
        $params = array_merge(['q' => $query], $options);
        $response = $this->req->get('/search/users', $params);

        if ($response->failed()) {
            throw new \Exception('Failed to search users: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Search issues and pull requests
     *
     * @param string $query The search query
     * @param array $options Additional options for the search
     * @return array
     */
    public function searchIssues(string $query, array $options = []): array
    {
        $params = array_merge(['q' => $query], $options);
        $response = $this->req->get('/search/issues', $params);

        if ($response->failed()) {
            throw new \Exception('Failed to search issues: '.$response->json()['message']);
        }

        return $response->json();
    }
}
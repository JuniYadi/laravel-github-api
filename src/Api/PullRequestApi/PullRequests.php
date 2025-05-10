<?php

namespace JuniYadi\GitHub\Api\PullRequestApi;

trait PullRequests
{
    /**
     * List pull requests in a repository
     *
     * @param string $repo
     * @param array $options
     * @return array
     */
    public function getPullRequests(string $repo, array $options = []): array
    {
        $response = $this->req->get("/repos/{$repo}/pulls", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch pull requests: ' . $response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Create a new pull request
     *
     * @param string $repo
     * @param string $title
     * @param string $head
     * @param string $base
     * @param string $body
     * @param array $options
     * @return array
     */
    public function createPullRequest(string $repo, string $title, string $head, string $base, string $body, array $options = []): array
    {
        $params = array_merge([
            'title' => $title,
            'head' => $head,
            'base' => $base,
            'body' => $body,
        ], $options);

        $response = $this->req->post("/repos/{$repo}/pulls", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to create pull request: ' . $response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Update an existing pull request
     *
     * @param string $repo
     * @param int $pr_number
     * @param array $options
     * @return array
     */
    public function updatePullRequest(string $repo, int $pr_number, array $options = []): array
    {
        $response = $this->req->patch("/repos/{$repo}/pulls/{$pr_number}", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to update pull request: ' . $response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Merge a pull request
     *
     * @param string $repo
     * @param int $pr_number
     * @param array $options
     * @return array
     */
    public function mergePullRequest(string $repo, int $pr_number, array $options = []): array
    {
        $response = $this->req->put("/repos/{$repo}/pulls/{$pr_number}/merge", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to merge pull request: ' . $response->json()['message']);
        }

        return $response->json();
    }

    /**
     * List files in a pull request
     *
     * @param string $repo
     * @param int $pr_number
     * @return array
     */
    public function getPullRequestFiles(string $repo, int $pr_number): array
    {
        $response = $this->req->get("/repos/{$repo}/pulls/{$pr_number}/files");

        if ($response->failed()) {
            throw new \Exception('Failed to fetch pull request files: ' . $response->json()['message']);
        }

        return $response->json();
    }
}
<?php

namespace JuniYadi\GitHub\Api\IssueApi;

trait Issues
{
    /**
     * List issues in a repository
     *
     * @param string $repo
     * @param array $options
     * @return array
     */
    public function getIssues(string $repo, array $options = []): array
    {
        $response = $this->req->get("/repos/{$repo}/issues", $options);
        
        if ($response->failed()) {
            throw new \Exception('Failed to fetch issues: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Create a new issue
     *
     * @param string $repo
     * @param string $title
     * @param string $body
     * @param array $options
     * @return array
     */
    public function createIssue(string $repo, string $title, string $body, array $options = []): array
    {
        $params = array_merge([
            'title' => $title,
            'body' => $body,
        ], $options);

        $response = $this->req->post("/repos/{$repo}/issues", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to create issue: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Update an existing issue
     *
     * @param string $repo
     * @param int $issue_number
     * @param array $options
     * @return array
     */
    public function updateIssue(string $repo, int $issue_number, array $options = []): array
    {
        $response = $this->req->patch("/repos/{$repo}/issues/{$issue_number}", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to update issue: '.$response->json()['message']);
        }

        return $response->json();
    }
}
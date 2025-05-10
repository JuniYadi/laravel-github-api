<?php

namespace JuniYadi\GitHub\Api\IssueApi;

trait Comments
{
    /**
     * Get comments on an issue
     *
     * @param string $repo
     * @param int $issue_number
     * @param array $options
     * @return array
     */
    public function getIssueComments(string $repo, int $issue_number, array $options = []): array
    {
        $response = $this->req->get("/repos/{$repo}/issues/{$issue_number}/comments", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch issue comments: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Comment on an issue
     *
     * @param string $repo
     * @param int $issue_number
     * @param string $body
     * @return array
     */
    public function createIssueComment(string $repo, int $issue_number, string $body): array
    {
        $response = $this->req->post("/repos/{$repo}/issues/{$issue_number}/comments", [
            'body' => $body,
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to create issue comment: '.$response->json()['message']);
        }

        return $response->json();
    }
}
<?php

namespace JuniYadi\GitHub\Api\CheckRunsApi;

trait CheckRuns
{
    /**
     * Get check runs for a reference
     *
     * @param string $repo
     * @param string $ref
     * @param array $options
     * @return array
     */
    public function getCheckRuns(string $repo, string $ref, array $options = []): array
    {
        $response = $this->req->get("/repos/{$repo}/commits/{$ref}/check-runs", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch check runs: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Create a check run
     *
     * @param string $repo
     * @param string $name
     * @param string $head_sha
     * @param array $options
     * @return array
     */
    public function createCheckRun(string $repo, string $name, string $head_sha, array $options = []): array
    {
        $params = array_merge([
            'name' => $name,
            'head_sha' => $head_sha,
        ], $options);

        $response = $this->req->post("/repos/{$repo}/check-runs", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to create check run: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Update a check run
     *
     * @param string $repo
     * @param int $check_run_id
     * @param array $options
     * @return array
     */
    public function updateCheckRun(string $repo, int $check_run_id, array $options = []): array
    {
        $response = $this->req->patch("/repos/{$repo}/check-runs/{$check_run_id}", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to update check run: '.$response->json()['message']);
        }

        return $response->json();
    }
}
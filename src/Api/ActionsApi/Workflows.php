<?php

namespace JuniYadi\GitHub\Api\ActionsApi;

trait Workflows
{
    /**
     * List workflows in a repository
     *
     * @param string $repo
     * @return array
     */
    public function getWorkflows(string $repo): array
    {
        $response = $this->req->get("/repos/{$repo}/actions/workflows");
        
        if ($response->failed()) {
            throw new \Exception('Failed to fetch workflows: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * List workflow runs
     *
     * @param string $repo
     * @param string $workflow_id
     * @param array $options
     * @return array
     */
    public function getWorkflowRuns(string $repo, string $workflow_id, array $options = []): array
    {
        $response = $this->req->get("/repos/{$repo}/actions/workflows/{$workflow_id}/runs", $options);
        
        if ($response->failed()) {
            throw new \Exception('Failed to fetch workflow runs: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Re-run a workflow
     *
     * @param string $repo
     * @param string $run_id
     * @return array
     */
    public function rerunWorkflow(string $repo, string $run_id): array
    {
        $response = $this->req->post("/repos/{$repo}/actions/runs/{$run_id}/rerun");
        
        if ($response->failed()) {
            throw new \Exception('Failed to re-run workflow: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Download workflow logs
     *
     * @param string $repo
     * @param string $run_id
     * @return array
     */
    public function getWorkflowRunLogs(string $repo, string $run_id): array
    {
        $response = $this->req->get("/repos/{$repo}/actions/runs/{$run_id}/logs");
        
        if ($response->failed()) {
            throw new \Exception('Failed to download workflow logs: '.$response->json()['message']);
        }

        return $response->json();
    }
}
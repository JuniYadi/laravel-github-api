<?php

namespace JuniYadi\GitHub\Contracts;

interface ActionsApiInterface
{
    /**
     * List workflows in a repository
     *
     * @param string $repo
     * @return array
     */
    public function getWorkflows(string $repo): array;

    /**
     * List workflow runs
     *
     * @param string $repo
     * @param string $workflow_id
     * @param array $options
     * @return array
     */
    public function getWorkflowRuns(string $repo, string $workflow_id, array $options = []): array;

    /**
     * Re-run a workflow
     *
     * @param string $repo
     * @param string $run_id
     * @return array
     */
    public function rerunWorkflow(string $repo, string $run_id): array;

    /**
     * Download workflow logs
     *
     * @param string $repo
     * @param string $run_id
     * @return array
     */
    public function getWorkflowRunLogs(string $repo, string $run_id): array;
}
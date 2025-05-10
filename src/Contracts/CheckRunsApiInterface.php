<?php

namespace JuniYadi\GitHub\Contracts;

interface CheckRunsApiInterface
{
    /**
     * Get check runs for a reference
     *
     * @param string $repo
     * @param string $ref
     * @param array $options
     * @return array
     */
    public function getCheckRuns(string $repo, string $ref, array $options = []): array;

    /**
     * Create a check run
     *
     * @param string $repo
     * @param string $name
     * @param string $head_sha
     * @param array $options
     * @return array
     */
    public function createCheckRun(string $repo, string $name, string $head_sha, array $options = []): array;

    /**
     * Update a check run
     *
     * @param string $repo
     * @param int $check_run_id
     * @param array $options
     * @return array
     */
    public function updateCheckRun(string $repo, int $check_run_id, array $options = []): array;
}
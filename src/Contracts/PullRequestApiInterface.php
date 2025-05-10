<?php

namespace JuniYadi\GitHub\Contracts;

interface PullRequestApiInterface
{
    /**
     * List pull requests in a repository
     *
     * @param string $repo
     * @param array $options
     * @return array
     */
    public function getPullRequests(string $repo, array $options = []): array;

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
    public function createPullRequest(string $repo, string $title, string $head, string $base, string $body, array $options = []): array;

    /**
     * Update an existing pull request
     *
     * @param string $repo
     * @param int $pr_number
     * @param array $options
     * @return array
     */
    public function updatePullRequest(string $repo, int $pr_number, array $options = []): array;

    /**
     * Merge a pull request
     *
     * @param string $repo
     * @param int $pr_number
     * @param array $options
     * @return array
     */
    public function mergePullRequest(string $repo, int $pr_number, array $options = []): array;

    /**
     * List files in a pull request
     *
     * @param string $repo
     * @param int $pr_number
     * @return array
     */
    public function getPullRequestFiles(string $repo, int $pr_number): array;
}
<?php

namespace JuniYadi\GitHub\Contracts;

interface IssueApiInterface
{
    /**
     * List issues in a repository
     *
     * @param string $repo
     * @param array $options
     * @return array
     */
    public function getIssues(string $repo, array $options = []): array;

    /**
     * Create a new issue
     *
     * @param string $repo
     * @param string $title
     * @param string $body
     * @param array $options
     * @return array
     */
    public function createIssue(string $repo, string $title, string $body, array $options = []): array;

    /**
     * Update an existing issue
     *
     * @param string $repo
     * @param int $issue_number
     * @param array $options
     * @return array
     */
    public function updateIssue(string $repo, int $issue_number, array $options = []): array;

    /**
     * Get comments on an issue
     *
     * @param string $repo
     * @param int $issue_number
     * @param array $options
     * @return array
     */
    public function getIssueComments(string $repo, int $issue_number, array $options = []): array;

    /**
     * Comment on an issue
     *
     * @param string $repo
     * @param int $issue_number
     * @param string $body
     * @return array
     */
    public function createIssueComment(string $repo, int $issue_number, string $body): array;
}
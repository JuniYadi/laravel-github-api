<?php

namespace JuniYadi\LaravelGithubApi\Contracts;

interface SearchApiInterface
{
    /**
     * Search repositories
     *
     * @param string $query The search query
     * @param array $options Additional options for the search
     * @return array
     */
    public function searchRepositories(string $query, array $options = []): array;

    /**
     * Search code
     *
     * @param string $query The search query
     * @param array $options Additional options for the search
     * @return array
     */
    public function searchCode(string $query, array $options = []): array;

    /**
     * Search users
     *
     * @param string $query The search query
     * @param array $options Additional options for the search
     * @return array
     */
    public function searchUsers(string $query, array $options = []): array;

    /**
     * Search issues and pull requests
     *
     * @param string $query The search query
     * @param array $options Additional options for the search
     * @return array
     */
    public function searchIssues(string $query, array $options = []): array;
}
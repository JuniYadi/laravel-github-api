<?php

namespace JuniYadi\GitHub\Contracts;

interface ProjectApiInterface
{
    /**
     * List projects for a repo, org, or user
     *
     * @param string $owner Repository owner, organization name, or username
     * @param string $type Type of owner ('repos', 'orgs', or 'users')
     * @param array $options Additional options
     * @return array
     */
    public function getProjects(string $owner, string $type, array $options = []): array;

    /**
     * Create a project
     *
     * @param string $owner Repository owner, organization name, or username
     * @param string $type Type of owner ('repos', 'orgs', or 'users')
     * @param string $name Project name
     * @param string $body Project description
     * @param array $options Additional options
     * @return array
     */
    public function createProject(string $owner, string $type, string $name, string $body, array $options = []): array;

    /**
     * Update a project
     *
     * @param int $project_id Project ID
     * @param array $options Update options (name, body, state, etc.)
     * @return array
     */
    public function updateProject(int $project_id, array $options = []): array;

    /**
     * Delete a project
     *
     * @param int $project_id Project ID
     * @return array
     */
    public function deleteProject(int $project_id): array;
}
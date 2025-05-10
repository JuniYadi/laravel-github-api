<?php

namespace JuniYadi\GitHub\Api\ProjectApi;

trait Projects
{
    /**
     * List projects for a repo, org, or user
     *
     * @param string $owner Repository owner, organization name, or username
     * @param string $type Type of owner ('repos', 'orgs', or 'users')
     * @param array $options Additional options
     * @return array
     */
    public function getProjects(string $owner, string $type, array $options = []): array
    {
        $response = $this->req->get("/{$type}/{$owner}/projects", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch projects: '.$response->json()['message']);
        }

        return $response->json();
    }

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
    public function createProject(string $owner, string $type, string $name, string $body, array $options = []): array
    {
        $params = array_merge([
            'name' => $name,
            'body' => $body,
        ], $options);

        $response = $this->req->post("/{$type}/{$owner}/projects", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to create project: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Update a project
     *
     * @param int $project_id Project ID
     * @param array $options Update options (name, body, state, etc.)
     * @return array
     */
    public function updateProject(int $project_id, array $options = []): array
    {
        $response = $this->req->patch("/projects/{$project_id}", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to update project: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Delete a project
     *
     * @param int $project_id Project ID
     * @return array
     */
    public function deleteProject(int $project_id): array
    {
        $response = $this->req->delete("/projects/{$project_id}");

        if ($response->failed()) {
            throw new \Exception('Failed to delete project: '.$response->json()['message']);
        }

        return $response->json();
    }
}
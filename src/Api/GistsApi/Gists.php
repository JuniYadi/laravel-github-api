<?php

namespace JuniYadi\GitHub\Api\GistsApi;

trait Gists
{
    /**
     * List gists for authenticated user
     *
     * @param array $options
     * @return array
     */
    public function getGists(array $options = []): array
    {
        $response = $this->req->get('/gists', $options);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch gists: ' . $response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Create a gist
     *
     * @param array $files
     * @param string $description
     * @param bool $public
     * @return array
     */
    public function createGist(array $files, string $description = '', bool $public = false): array
    {
        $params = [
            'files' => $files,
            'description' => $description,
            'public' => $public,
        ];

        $response = $this->req->post('/gists', $params);

        if ($response->failed()) {
            throw new \Exception('Failed to create gist: ' . $response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Update a gist
     *
     * @param string $gist_id
     * @param array $files
     * @param array $options
     * @return array
     */
    public function updateGist(string $gist_id, array $files, array $options = []): array
    {
        $params = array_merge([
            'files' => $files,
        ], $options);

        $response = $this->req->patch("/gists/{$gist_id}", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to update gist: ' . $response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Delete a gist
     *
     * @param string $gist_id
     * @return array
     */
    public function deleteGist(string $gist_id): array
    {
        $response = $this->req->delete("/gists/{$gist_id}");

        if ($response->failed()) {
            throw new \Exception('Failed to delete gist: ' . $response->json()['message']);
        }

        return $response->json();
    }
}
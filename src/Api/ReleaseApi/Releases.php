<?php

namespace JuniYadi\GitHub\Api\ReleaseApi;

trait Releases
{
    /**
     * List releases for a repository
     *
     * @param string $repo
     * @param array $options
     * @return array
     */
    public function getReleases(string $repo, array $options = []): array
    {
        $response = $this->req->get("/repos/{$repo}/releases", $options);
        
        if ($response->failed()) {
            throw new \Exception('Failed to fetch releases: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Get a single release
     *
     * @param string $repo
     * @param int $release_id
     * @return array
     */
    public function getRelease(string $repo, int $release_id): array
    {
        $response = $this->req->get("/repos/{$repo}/releases/{$release_id}");
        
        if ($response->failed()) {
            throw new \Exception('Failed to fetch release: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Create a release
     *
     * @param string $repo
     * @param string $tag_name
     * @param array $options
     * @return array
     */
    public function createRelease(string $repo, string $tag_name, array $options = []): array
    {
        $params = array_merge([
            'tag_name' => $tag_name,
        ], $options);

        $response = $this->req->post("/repos/{$repo}/releases", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to create release: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Update a release
     *
     * @param string $repo
     * @param int $release_id
     * @param array $options
     * @return array
     */
    public function updateRelease(string $repo, int $release_id, array $options = []): array
    {
        $response = $this->req->patch("/repos/{$repo}/releases/{$release_id}", $options);

        if ($response->failed()) {
            throw new \Exception('Failed to update release: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Delete a release
     *
     * @param string $repo
     * @param int $release_id
     * @return array
     */
    public function deleteRelease(string $repo, int $release_id): array
    {
        $response = $this->req->delete("/repos/{$repo}/releases/{$release_id}");

        if ($response->failed()) {
            throw new \Exception('Failed to delete release: '.$response->json()['message']);
        }

        return $response->json();
    }
}
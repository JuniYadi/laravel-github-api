<?php

namespace JuniYadi\GitHub\Contracts;

interface ReleaseApiInterface
{
    /**
     * List releases for a repository
     *
     * @param string $repo
     * @param array $options
     * @return array
     */
    public function getReleases(string $repo, array $options = []): array;

    /**
     * Get a single release
     *
     * @param string $repo
     * @param int $release_id
     * @return array
     */
    public function getRelease(string $repo, int $release_id): array;

    /**
     * Create a release
     *
     * @param string $repo
     * @param string $tag_name
     * @param array $options
     * @return array
     */
    public function createRelease(string $repo, string $tag_name, array $options = []): array;

    /**
     * Update a release
     *
     * @param string $repo
     * @param int $release_id
     * @param array $options
     * @return array
     */
    public function updateRelease(string $repo, int $release_id, array $options = []): array;

    /**
     * Delete a release
     *
     * @param string $repo
     * @param int $release_id
     * @return array
     */
    public function deleteRelease(string $repo, int $release_id): array;
}
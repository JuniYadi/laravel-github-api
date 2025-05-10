<?php

namespace JuniYadi\GitHub\Contracts;

interface GistsApiInterface
{
    /**
     * List gists for authenticated user
     *
     * @param array $options
     * @return array
     */
    public function getGists(array $options = []): array;

    /**
     * Create a gist
     *
     * @param array $files
     * @param string $description
     * @param bool $public
     * @return array
     */
    public function createGist(array $files, string $description = '', bool $public = false): array;

    /**
     * Update a gist
     *
     * @param string $gist_id
     * @param array $files
     * @param array $options
     * @return array
     */
    public function updateGist(string $gist_id, array $files, array $options = []): array;

    /**
     * Delete a gist
     *
     * @param string $gist_id
     * @return array
     */
    public function deleteGist(string $gist_id): array;
}
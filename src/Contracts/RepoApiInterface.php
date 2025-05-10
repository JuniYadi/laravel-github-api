<?php

namespace JuniYadi\GitHub\Contracts;

interface RepoApiInterface
{
    /**
     * List repositories for a user.
     *
     * @param  string  $username
     * @param  array  $options
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function getRepositories($username, array $options = []);

    /**
     * List branches for a repository.
     *
     * @param  string  $repo
     * @param  array  $options
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function getBranches($repo, array $options = []);

    /**
     * Show repository or file details.
     *
     * @param  string  $repo
     * @param  string|null  $file
     * @param  array  $options
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function show($repo, $file = null, array $options = []);

    /**
     * Delete a file from a repository.
     *
     * @param  string  $repo
     * @param  string  $file
     * @param  string  $message
     * @param  array  $options
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function delete($repo, $file, $message, array $options = []);

    /**
     * Upload a file to a repository.
     *
     * @param  string  $repo
     * @param  string  $file
     * @param  string  $message
     * @param  string  $content
     * @param  array  $options
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function upload($repo, $file, $message, $content, array $options = []);
    
    /**
     * Upload multiple files to a repository.
     *
     * @param  string  $repo
     * @param  array  $files  Array of ['file' => ..., 'content' => ..., 'message' => ...]
     * @param  array  $options
     * @return array
     */
    public function uploadBulk($repo, array $files, array $options = []);
    
    /**
     * Upload multiple files to a repository using Git Data API (blobs/trees/commits).
     *
     * @param  string  $repo
     * @param  string  $branch
     * @param  array  $files  Array of ['file' => ..., 'content' => ...]
     * @param  string  $message
     * @return array
     */
    public function uploadBulkBlob($repo, $branch, array $files, $message);
    
    /**
     * Delete multiple files from a repository.
     *
     * @param  string  $repo
     * @param  array  $files  Array of ['file' => ..., 'message' => ...]
     * @param  array  $options
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function deleteBulk($repo, array $files, array $options = []);
    
    /**
     * Delete multiple files or directories from a repository using Git Data API.
     *
     * @param  string  $repo
     * @param  string  $branch
     * @param  array  $files  Array of file paths or directory paths to delete
     * @param  string  $message
     * @param  array  $options
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function deleteBulkBlob($repo, $branch, array $files, $message, array $options = []);
}

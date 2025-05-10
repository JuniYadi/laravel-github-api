<?php

namespace JuniYadi\GitHub\Api\RepoApi;

trait Delete
{
    // Handler for deleting files (delete)

    /**
     * Delete a file from a repository.
     *
     * @param  string  $repo
     * @param  string  $file
     * @param  string  $message
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function delete($repo, $file, $message, array $options = [])
    {
        if (empty($repo)) {
            throw new \InvalidArgumentException('Repository cannot be empty.');
        }
        if (! preg_match('/^[a-zA-Z0-9-]+\/[a-zA-Z0-9-]+$/', $repo)) {
            throw new \InvalidArgumentException('Invalid repository format.');
        }
        if (empty($file)) {
            throw new \InvalidArgumentException('File cannot be empty.');
        }
        if (empty($message)) {
            throw new \InvalidArgumentException('Commit message cannot be empty.');
        }
        $params = array_filter($options);
        $endpoint = "/repos/{$repo}/contents/{$file}";
        // Get file SHA using Show handler
        $checkResponse = $this->show($repo, $file);
        if (! isset($checkResponse['sha'])) {
            throw new \Exception('File does not exist.');
        }
        $data = [
            'message' => $message,
            'sha' => $checkResponse['sha'],
        ];
        $response = $this->req->delete($endpoint, array_merge($params, $data));
        if ($response->failed()) {
            throw new \Exception('Failed to delete file: '.$response->json()['message']);
        }

        return $response->json();
    }

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
    public function deleteBulk($repo, array $files, array $options = [])
    {
        if (empty($repo)) {
            throw new \InvalidArgumentException('Repository cannot be empty.');
        }
        if (! is_array($files) || empty($files)) {
            throw new \InvalidArgumentException('Files array cannot be empty.');
        }
        
        $results = [];
        foreach ($files as $fileData) {
            if (! isset($fileData['file'], $fileData['message'])) {
                throw new \InvalidArgumentException('Each file must have file and message keys.');
            }
            
            try {
                $result = $this->delete(
                    $repo,
                    $fileData['file'],
                    $fileData['message'],
                    $options
                );
                $results[] = [
                    'file' => $fileData['file'],
                    'status' => 'deleted',
                    'response' => $result
                ];
            } catch (\Exception $e) {
                $results[] = [
                    'file' => $fileData['file'],
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }

        return $results;
    }

    /**
     * Delete multiple files from a repository using Git Data API (trees/commits).
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
    public function deleteBulkBlob($repo, $branch = 'main', array $files, $message = 'Bulk delete', array $options = [])
    {
        if (empty($repo)) {
            throw new \InvalidArgumentException('Repository cannot be empty.');
        }
        if (! is_array($files) || empty($files)) {
            throw new \InvalidArgumentException('Files array cannot be empty.');
        }
        
        // 1. Get the latest commit SHA on the branch
        $ref = $this->req->get("/repos/{$repo}/git/ref/heads/{$branch}");
        if ($ref->failed()) {
            throw new \Exception('Failed to get branch reference.');
        }
        $commitSha = $ref->json()['object']['sha'];
        
        // 2. Get the tree SHA from the latest commit
        $commit = $this->req->get("/repos/{$repo}/git/commits/{$commitSha}");
        if ($commit->failed()) {
            throw new \Exception('Failed to get commit.');
        }
        $baseTreeSha = $commit->json()['tree']['sha'];
        
        // 3. Get the complete tree recursively
        $fullTree = $this->req->get("/repos/{$repo}/git/trees/{$baseTreeSha}", [
            'recursive' => 1
        ]);
        if ($fullTree->failed()) {
            throw new \Exception('Failed to get repository tree.');
        }
        
        $treeItems = $fullTree->json()['tree'];
        $newTree = [];
        $hasChanges = false;
        $deletedPaths = []; // Track which paths were actually deleted
        
        // 4. Create a new tree excluding the files and directories we want to delete
        foreach ($treeItems as $item) {
            $shouldDelete = false;
            $normalizedPath = ltrim($item['path'], '/');
            
            foreach ($files as $pathToDelete) {
                $normalizedPathToDelete = ltrim($pathToDelete, '/');
                
                // Case 1: Exact file match
                if ($normalizedPath === $normalizedPathToDelete) {
                    $shouldDelete = true;
                    $deletedPaths[] = $normalizedPath;
                    $hasChanges = true;
                    break;
                }
                
                // Case 2: Directory match - check if this path is inside the directory to delete
                // Make sure the path to delete is a directory (has trailing slash or we add one)
                $normalizedDirToDelete = rtrim($normalizedPathToDelete, '/') . '/';
                
                // Check if the current item's path starts with the directory we want to delete
                if (strpos($normalizedPath . '/', $normalizedDirToDelete) === 0) {
                    $shouldDelete = true;
                    $deletedPaths[] = $normalizedPath;
                    $hasChanges = true;
                    break;
                }
            }
            
            // Only keep files that shouldn't be deleted
            if (!$shouldDelete) {
                $newTree[] = [
                    'path' => $item['path'],
                    'mode' => $item['mode'],
                    'type' => $item['type'],
                    'sha' => $item['sha'],
                ];
            }
        }
        
        // If no files were found to delete, return early
        if (!$hasChanges) {
            return [
                'success' => true,
                'message' => 'No files found to delete. Skipping commit.',
                'files' => $files,
                'changed' => false,
                'deleted_paths' => [],
            ];
        }
        
        // 5. Create a new tree
        $newTreeObject = $this->req->post("/repos/{$repo}/git/trees", [
            'base_tree' => null, // Don't use base tree as we're providing the full structure
            'tree' => $newTree,
        ]);
        
        if ($newTreeObject->failed()) {
            throw new \Exception('Failed to create tree: ' . $newTreeObject->json()['message']);
        }
        $newTreeSha = $newTreeObject->json()['sha'];
        
        // 6. Create a new commit
        $newCommit = $this->req->post("/repos/{$repo}/git/commits", [
            'message' => $message,
            'tree' => $newTreeSha,
            'parents' => [$commitSha],
        ]);
        
        if ($newCommit->failed()) {
            throw new \Exception('Failed to create commit: ' . $newCommit->json()['message']);
        }
        $newCommitSha = $newCommit->json()['sha'];
        
        // 7. Update the branch reference
        $updateRef = $this->req->patch("/repos/{$repo}/git/refs/heads/{$branch}", [
            'sha' => $newCommitSha,
            'force' => true,
        ]);
        
        if ($updateRef->failed()) {
            throw new \Exception('Failed to update branch reference: ' . $updateRef->json()['message']);
        }
        
        return [
            'success' => true,
            'commit' => $newCommit->json(),
            'tree' => $newTreeObject->json(),
            'files' => $files,
            'deleted_paths' => array_unique($deletedPaths),
            'changed' => true,
        ];
    }
}

<?php

namespace JuniYadi\GitHub\Api\RepoApi;

trait UploadBulk
{
    /**
     * Upload multiple files to a repository.
     *
     * @param  string  $repo
     * @param  array  $files  Array of ['file' => ..., 'content' => ..., 'message' => ...]
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function uploadBulk($repo, array $files, array $options = [])
    {
        if (empty($repo)) {
            throw new \InvalidArgumentException('Repository cannot be empty.');
        }
        if (! is_array($files) || empty($files)) {
            throw new \InvalidArgumentException('Files array cannot be empty.');
        }
        $results = [];
        foreach ($files as $fileData) {
            if (! isset($fileData['file'], $fileData['content'], $fileData['message'])) {
                throw new \InvalidArgumentException('Each file must have file, content, and message keys.');
            }
            $result = $this->upload(
                $repo,
                $fileData['file'],
                $fileData['message'],
                $fileData['content'],
                $options
            );
            // Optionally, you can log or handle skipped uploads here
            $results[] = $result;
        }

        return $results;
    }

    /**
     * Upload multiple files to a repository using Git Data API (blobs/trees/commits).
     *
     * @param string $repo
     * @param string $branch
     * @param array $files Array of ['file' => ..., 'content' => ...]
     * @param string $message
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function uploadBulkBlob($repo, $branch = 'main', array $files, $message = 'Bulk upload')
    {
        if (empty($repo)) {
            throw new \InvalidArgumentException('Repository cannot be empty.');
        }
        if (!is_array($files) || empty($files)) {
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
        
        // Track if any files have changed
        $hasChanges = false;
        
        // 3. Create blobs for each file
        $tree = [];
        foreach ($files as $fileData) {
            if (!isset($fileData['file'], $fileData['content'])) {
                throw new \InvalidArgumentException('Each file must have file and content keys.');
            }
            
            // Check if file exists and if content has changed
            $fileChanged = true;
            try {
                $existingFile = $this->show($repo, $fileData['file'], ['ref' => $branch]);
                if (isset($existingFile['content'])) {
                    $existingContent = base64_decode($existingFile['content']);
                    // Compare contents to determine if file has changed
                    if ($existingContent === $fileData['content']) {
                        $fileChanged = false;
                        // If file hasn't changed, we still need to include it in the tree
                        $tree[] = [
                            'path' => $fileData['file'],
                            'mode' => '100644',
                            'type' => 'blob',
                            'sha' => $existingFile['sha'],
                        ];
                    }
                }
            } catch (\Exception $e) {
                // File doesn't exist yet, so it's a new file
                $fileChanged = true;
            }
            
            // Only create a blob if the file is new or has changed
            if ($fileChanged) {
                $hasChanges = true;
                $blob = $this->req->post("/repos/{$repo}/git/blobs", [
                    'content' => $fileData['content'],
                    'encoding' => 'utf-8',
                ]);
                
                if ($blob->failed()) {
                    throw new \Exception('Failed to create blob for file: ' . $fileData['file']);
                }
                
                $tree[] = [
                    'path' => $fileData['file'],
                    'mode' => '100644',
                    'type' => 'blob',
                    'sha' => $blob->json()['sha'],
                ];
            }
        }
        
        // If no files have changed, return early
        if (!$hasChanges) {
            return [
                'success' => true,
                'message' => 'No changes detected. Skipping commit.',
                'files' => $files,
                'changed' => false,
            ];
        }

        // 4. Create a new tree
        $newTree = $this->req->post("/repos/{$repo}/git/trees", [
            'base_tree' => $baseTreeSha,
            'tree' => $tree,
        ]);
        
        if ($newTree->failed()) {
            throw new \Exception('Failed to create tree.');
        }
        $newTreeSha = $newTree->json()['sha'];
        
        // If the new tree SHA matches the base tree SHA, no changes were made
        if ($newTreeSha === $baseTreeSha) {
            return [
                'success' => true,
                'message' => 'No changes detected in tree. Skipping commit.',
                'files' => $files,
                'changed' => false,
            ];
        }

        // 5. Create a new commit
        $newCommit = $this->req->post("/repos/{$repo}/git/commits", [
            'message' => $message,
            'tree' => $newTreeSha,
            'parents' => [$commitSha],
        ]);
        
        if ($newCommit->failed()) {
            throw new \Exception('Failed to create commit.');
        }
        $newCommitSha = $newCommit->json()['sha'];

        // 6. Update the branch reference
        $updateRef = $this->req->patch("/repos/{$repo}/git/refs/heads/{$branch}", [
            'sha' => $newCommitSha,
        ]);
        
        if ($updateRef->failed()) {
            throw new \Exception('Failed to update branch reference.');
        }

        return [
            'commit' => $newCommit->json(),
            'tree' => $newTree->json(),
            'files' => $files,
            'changed' => true,
        ];
    }
}

<?php

namespace JuniYadi\GitHub\Api\RepoApi;

use Illuminate\Support\Str;

trait Upload
{
    /**
     * Upload a file to a repository.
     *
     * @param  string  $repo
     * @param  string  $file
     * @param  string  $message
     * @param  string  $content
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function upload($repo, $file, $message, $content, array $options = [])
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
        if (empty($content)) {
            throw new \InvalidArgumentException('Content cannot be empty.');
        }
        if (
            Str::of($file)->startsWith('/') ||
            Str::of($file)->contains(['..', './', '/.']) ||
            empty(basename($file))
        ) {
            throw new \InvalidArgumentException('Invalid file path.');
        }
        $params = array_filter($options);
        $endpoint = "/repos/{$repo}/contents/{$file}";
        $force = isset($options['force']) && $options['force'];
        // Check if file exists
        $exists = false;
        $sha = null;
        $checkResponse = $this->show($repo, $file);
        if (isset($checkResponse['sha'])) {
            $exists = true;
            $sha = $checkResponse['sha'];
            // Compare SHA if file exists
            // GitHub blob SHA: sha1("blob ".strlen($content)."\0".$content)
            $newSha = sha1('blob '.strlen($content)."\0".$content);
            if ($sha === $newSha) {
                return [
                    'repo' => $repo,
                    'file' => $file,
                    'skipped' => true,
                    'reason' => 'No changes detected (SHA match).',
                ];
            }
        }
        if ($exists && ! $force) {
            throw new \Exception('File already exists. Use force option to override.');
        }
        $data = [
            'message' => $message,
            'content' => base64_encode($content),
        ];
        if ($exists && $force && $sha) {
            $data['sha'] = $sha;
        }
        $response = $this->req->put($endpoint, array_merge($params, $data));
        if ($response->failed()) {
            throw new \Exception('Failed to upload file: '.$response->json()['message']);
        }

        return $response->json();
    }
}

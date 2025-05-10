<?php

namespace JuniYadi\GitHub\Api\RepoApi;

trait Show
{
    // Handler for showing repository or file details (show)

    /**
     * Show repository or file details.
     *
     * @param  string  $repo
     * @param  string|null  $file
     * @return array
     *
     * @throws \InvalidArgumentException|\Exception
     */
    public function show($repo, $file = null, array $options = [])
    {
        if (empty($repo)) {
            throw new \InvalidArgumentException('Repository cannot be empty.');
        }
        if (! preg_match('/^[a-zA-Z0-9-]+\/[a-zA-Z0-9-]+$/', $repo)) {
            throw new \InvalidArgumentException('Invalid repository format.');
        }
        $params = array_filter($options);
        $endpoint = is_null($file)
            ? "/repos/{$repo}/contents/"
            : "/repos/{$repo}/contents/{$file}";
        $response = $this->req->get($endpoint, $params);
        if ($response->failed()) {
            throw new \Exception('Failed to fetch repository: '.$response->json()['message']);
        }

        return $response->json();
    }
}

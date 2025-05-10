<?php

namespace JuniYadi\GitHub\Api\OrgApi;

trait Repositories
{
    public function repositories($org, array $options = [])
    {
        if (empty($org)) {
            throw new \InvalidArgumentException('Organization name cannot be empty.');
        }
        $defaultOptions = [
            'type' => 'all',
            'sort' => 'full_name',
            'direction' => 'asc',
            'per_page' => 30,
            'page' => 1,
        ];
        $params = array_merge($defaultOptions, array_filter($options));
        $response = $this->req->get("{$this->baseUrl}/orgs/{$org}/repos", $params);
        if ($response->failed()) {
            throw new \Exception('Failed to fetch organization repositories: '.$response->json()['message']);
        }

        return $response->json();
    }
}

<?php

namespace JuniYadi\GitHub\Api\WebhookApi;

trait Webhooks
{
    /**
     * List webhooks for a repository
     *
     * @param string $repo
     * @return array
     */
    public function getWebhooks(string $repo): array
    {
        $response = $this->req->get("/repos/{$repo}/hooks");
        
        if ($response->failed()) {
            throw new \Exception('Failed to fetch webhooks: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Create a webhook
     *
     * @param string $repo
     * @param array $config
     * @param array $events
     * @param array $options
     * @return array
     */
    public function createWebhook(string $repo, array $config, array $events, array $options = []): array
    {
        $params = array_merge([
            'config' => $config,
            'events' => $events,
            'active' => true
        ], $options);

        $response = $this->req->post("/repos/{$repo}/hooks", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to create webhook: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Update a webhook
     *
     * @param string $repo
     * @param int $hook_id
     * @param array $config
     * @param array $events
     * @param array $options
     * @return array
     */
    public function updateWebhook(string $repo, int $hook_id, array $config, array $events, array $options = []): array
    {
        $params = array_merge([
            'config' => $config,
            'events' => $events,
        ], $options);

        $response = $this->req->patch("/repos/{$repo}/hooks/{$hook_id}", $params);

        if ($response->failed()) {
            throw new \Exception('Failed to update webhook: '.$response->json()['message']);
        }

        return $response->json();
    }

    /**
     * Delete a webhook
     *
     * @param string $repo
     * @param int $hook_id
     * @return array
     */
    public function deleteWebhook(string $repo, int $hook_id): array
    {
        $response = $this->req->delete("/repos/{$repo}/hooks/{$hook_id}");

        if ($response->failed()) {
            throw new \Exception('Failed to delete webhook: '.$response->json()['message']);
        }

        return $response->json();
    }
}
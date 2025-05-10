<?php

namespace JuniYadi\GitHub\Contracts;

interface WebhookApiInterface
{
    /**
     * List webhooks for a repository
     *
     * @param string $repo
     * @return array
     */
    public function getWebhooks(string $repo): array;

    /**
     * Create a webhook
     *
     * @param string $repo
     * @param array $config
     * @param array $events
     * @param array $options
     * @return array
     */
    public function createWebhook(string $repo, array $config, array $events, array $options = []): array;

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
    public function updateWebhook(string $repo, int $hook_id, array $config, array $events, array $options = []): array;

    /**
     * Delete a webhook
     *
     * @param string $repo
     * @param int $hook_id
     * @return array
     */
    public function deleteWebhook(string $repo, int $hook_id): array;
}
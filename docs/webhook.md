# Webhooks API

The Webhooks API allows you to create, manage, and delete repository webhooks. Webhooks let you set up integrations to receive notifications when certain events occur in a repository.

## Installation

The Webhooks API is included in the Laravel GitHub API package. Make sure you have the package installed and configured:

```php
use JuniYadi\GitHub\Facades\Github;
```

## Available Methods

### List Webhooks

Get a list of webhooks configured for a repository.

```php
$webhooks = Github::webhook()->getWebhooks('owner/repo');
```

### Create Webhook

Create a new webhook in a repository.

```php
$webhook = Github::webhook()->createWebhook(
    'owner/repo',
    [
        'url' => 'https://example.com/webhook',
        'content_type' => 'json',
        'secret' => 'your-webhook-secret',
        'insecure_ssl' => '0'          // '0' to verify SSL, '1' to skip verification
    ],
    ['push', 'pull_request'],          // events to trigger webhook
    [
        'active' => true               // optional: set to false to create inactive webhook
    ]
);
```

Common webhook events:

- `push`: Any Git push to the repository
- `pull_request`: Activity on pull requests
- `issues`: Activity on issues
- `release`: Release activity
- `create`: Branch or tag creation
- `delete`: Branch or tag deletion
- `fork`: Repository is forked
- `star`: Repository is starred
- Use `*` to receive all supported events

### Update Webhook

Update an existing webhook's configuration.

```php
$updatedWebhook = Github::webhook()->updateWebhook(
    'owner/repo',
    12345,                             // hook_id
    [
        'url' => 'https://new-url.com/webhook',
        'content_type' => 'json',
        'secret' => 'updated-webhook-secret'
    ],
    ['push', 'issues'],                // updated events list
    [
        'active' => true               // optional: activate/deactivate webhook
    ]
);
```

### Delete Webhook

Remove a webhook from a repository.

```php
$result = Github::webhook()->deleteWebhook('owner/repo', 12345); // hook_id
```

## Webhook Configuration

### Config Options

The webhook configuration array supports these options:

- `url` (required): The URL to which the payloads will be delivered
- `content_type`: Payload format (default: 'json')
  - `json`: JSON payload
  - `form`: URL-encoded payload
- `secret`: Secret key for securing webhook deliveries
- `insecure_ssl`: SSL verification
  - `0`: Verify SSL certificate
  - `1`: Skip SSL certificate verification

### Event Types

Common event types you can subscribe to:

1. Repository Events:

   - `push`: Push to repository
   - `create`: Branch/tag created
   - `delete`: Branch/tag deleted
   - `fork`: Repository forked
   - `release`: Release activity

2. Issue Events:

   - `issues`: Issue activity
   - `issue_comment`: Issue comments
   - `label`: Label changes

3. Pull Request Events:

   - `pull_request`: PR activity
   - `pull_request_review`: PR reviews
   - `pull_request_review_comment`: PR review comments

4. Other Events:
   - `star`: Repository starred/unstarred
   - `workflow_run`: GitHub Actions workflow runs
   - `deployment`: Deployment activity
   - `member`: Collaborator changes

## Error Handling

All methods will throw an Exception with the GitHub API error message if the request fails. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $webhook = Github::webhook()->createWebhook(
        'owner/repo',
        [
            'url' => 'https://example.com/webhook',
            'content_type' => 'json'
        ],
        ['push']
    );
} catch (\Exception $e) {
    // Handle the error
    echo 'Failed to create webhook: ' . $e->getMessage();
}
```

## Response Format

All methods return the raw JSON response from the GitHub API as an array. Common response fields include:

- `id`: The webhook ID
- `type`: The type of webhook
- `name`: The webhook name (defaults to 'web')
- `active`: Whether the hook is active
- `events`: Array of events the webhook is subscribed to
- `config`: Webhook configuration
  - `url`: The URL receiving the webhooks
  - `content_type`: The content type being delivered
  - `insecure_ssl`: SSL verification setting
- `updated_at`: Last update timestamp
- `created_at`: Creation timestamp
- `last_response`: Information about the last webhook delivery
  - `code`: HTTP status code
  - `status`: Status message
  - `message`: Response message

## Best Practices

1. Always use a webhook secret to secure your endpoints
2. Implement proper validation of webhook payloads
3. Handle webhook deliveries asynchronously
4. Implement proper error handling and logging
5. Monitor webhook delivery status
6. Subscribe only to events you need
7. Ensure your endpoint can handle the webhook payload size
8. Implement proper rate limiting on your webhook endpoint

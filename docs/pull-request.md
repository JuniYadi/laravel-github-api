# Pull Requests API

The Pull Requests API allows you to list, create, update, merge, and get information about pull requests in a repository.

## Installation

The Pull Requests API is included in the Laravel GitHub API package. Make sure you have the package installed and configured:

```php
use JuniYadi\GitHub\Facades\Github;
```

## Available Methods

### List Pull Requests

Retrieve a list of pull requests in a repository.

```php
$pullRequests = Github::pullRequest()->getPullRequests('owner/repo', [
    'state' => 'open',     // optional: open, closed, or all
    'sort' => 'created',   // optional: created, updated, popularity, long-running
    'direction' => 'desc', // optional: asc or desc
    'per_page' => 30,     // optional: results per page (max 100)
    'page' => 1           // optional: page number
]);
```

### Create Pull Request

Create a new pull request.

```php
$pullRequest = Github::pullRequest()->createPullRequest(
    'owner/repo',
    'Update feature X',    // title
    'feature-branch',      // head branch
    'main',               // base branch
    'Description of changes made in this PR', // body
    [
        'draft' => false,  // optional: create as draft PR
        'maintainer_can_modify' => true // optional: allow maintainers to modify
    ]
);
```

### Update Pull Request

Update an existing pull request.

```php
$updatedPr = Github::pullRequest()->updatePullRequest(
    'owner/repo',
    123,  // PR number
    [
        'title' => 'Updated title',
        'body' => 'Updated description',
        'state' => 'closed', // open or closed
        'base' => 'main'     // base branch
    ]
);
```

### Merge Pull Request

Merge a pull request.

```php
$result = Github::pullRequest()->mergePullRequest(
    'owner/repo',
    123,  // PR number
    [
        'commit_title' => 'Custom merge commit title',    // optional
        'commit_message' => 'Custom merge message',       // optional
        'merge_method' => 'merge'                        // optional: merge, squash, or rebase
    ]
);
```

### List Files in Pull Request

Get a list of files modified in a pull request.

```php
$files = Github::pullRequest()->getPullRequestFiles('owner/repo', 123);
```

## Error Handling

All methods will throw an Exception with the GitHub API error message if the request fails. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $pullRequest = Github::pullRequest()->createPullRequest(
        'owner/repo',
        'Update feature',
        'feature-branch',
        'main',
        'Description'
    );
} catch (\Exception $e) {
    // Handle the error
    echo 'Failed to create pull request: ' . $e->getMessage();
}
```

## Response Format

All methods return the raw JSON response from the GitHub API as an array. The exact structure will depend on the endpoint being called. Common fields include:

- `number`: The pull request number
- `title`: The pull request title
- `body`: The pull request description
- `state`: The current state (open/closed/merged)
- `user`: Information about the user who created the PR
- `created_at`: Creation timestamp
- `updated_at`: Last update timestamp
- `merged_at`: Merge timestamp (if merged)
- `merge_commit_sha`: SHA of the merge commit (if merged)
- `head`: Information about the head branch
- `base`: Information about the base branch

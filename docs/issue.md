# Issues API

This documentation covers the Issues API implementation which allows you to manage GitHub issues and their comments.

## Usage

All issues-related methods are accessed through the `issue()` method on the GitHub client instance.

```php
$github = new JuniYadi\GitHub\Github();

// Access issues API
$issueApi = $github->issue();
```

## Available Methods

### List Repository Issues

Retrieve a list of issues from a repository.

```php
$issues = $github->issue()->getIssues('owner/repo', [
    'state' => 'open',    // open, closed, all
    'sort' => 'created',  // created, updated, comments
    'direction' => 'desc',
    'per_page' => 30,
    'page' => 1
]);
```

### Create an Issue

Create a new issue in a repository.

```php
$issue = $github->issue()->createIssue(
    'owner/repo',
    'Issue Title',
    'Issue Description',
    [
        'assignees' => ['username1', 'username2'],
        'labels' => ['bug', 'help wanted'],
        'milestone' => 1
    ]
);
```

### Update an Issue

Update an existing issue in a repository.

```php
$updatedIssue = $github->issue()->updateIssue(
    'owner/repo',
    123, // issue number
    [
        'title' => 'Updated Title',
        'body' => 'Updated description',
        'state' => 'closed',
        'assignees' => ['username1'],
        'labels' => ['fixed']
    ]
);
```

### Get Issue Comments

Retrieve comments from a specific issue.

```php
$comments = $github->issue()->getIssueComments(
    'owner/repo',
    123, // issue number
    [
        'per_page' => 30,
        'page' => 1
    ]
);
```

### Create Issue Comment

Add a new comment to an existing issue.

```php
$comment = $github->issue()->createIssueComment(
    'owner/repo',
    123, // issue number
    'This is a comment body'
);
```

## Error Handling

All methods will throw exceptions when requests fail. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $issues = $github->issue()->getIssues('owner/repo');
} catch (\Exception $e) {
    // Handle error - e.g., repository not found, authentication failed, etc.
    echo 'Error: ' . $e->getMessage();
}
```

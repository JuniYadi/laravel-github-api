# Check Runs API

The Check Runs API allows you to create and manage check runs, which provide detailed information about GitHub Actions, continuous integration builds, test runs, and other automated checks on Git references.

## Installation

The Check Runs API is included in the Laravel GitHub API package. Make sure you have the package installed and configured:

```php
use JuniYadi\GitHub\Facades\Github;
```

## Available Methods

### List Check Runs

Get a list of check runs for a specific Git reference (SHA, branch, or tag).

```php
$checkRuns = Github::checkRuns()->getCheckRuns(
    'owner/repo',
    'main',          // ref: branch name, commit SHA, or tag
    [
        'check_name' => 'test-suite',    // optional: filter by check name
        'status' => 'completed',         // optional: queued, in_progress, completed
        'filter' => 'all',              // optional: latest, all
        'per_page' => 30,               // optional: results per page (max 100)
        'page' => 1                     // optional: page number
    ]
);
```

### Create Check Run

Create a new check run for a specific commit SHA.

```php
$checkRun = Github::checkRuns()->createCheckRun(
    'owner/repo',
    'test-suite',    // name of the check run
    'abc123...',     // head_sha: The SHA of the commit
    [
        'status' => 'in_progress',      // optional: queued, in_progress, completed
        'conclusion' => null,           // optional: see conclusion options below
        'started_at' => '2024-01-01T00:00:00Z',  // optional: ISO 8601 timestamp
        'output' => [                   // optional: detailed output
            'title' => 'Test Results',
            'summary' => 'All tests passed',
            'text' => 'Detailed test results...',
            'annotations' => [          // optional: code annotations
                [
                    'path' => 'src/app.php',
                    'start_line' => 10,
                    'end_line' => 10,
                    'annotation_level' => 'warning',
                    'message' => 'Deprecated function used'
                ]
            ]
        ]
    ]
);
```

Conclusion options (when status is 'completed'):

- `success`: The check completed successfully
- `failure`: The check failed
- `neutral`: The check completed with a neutral result
- `cancelled`: The check was cancelled
- `timed_out`: The check timed out
- `action_required`: The check requires action
- `skipped`: The check was skipped

### Update Check Run

Update an existing check run with new status, conclusion, or output.

```php
$updatedCheckRun = Github::checkRuns()->updateCheckRun(
    'owner/repo',
    12345,          // check_run_id
    [
        'name' => 'updated-test-suite',  // optional: new name
        'status' => 'completed',         // optional: new status
        'conclusion' => 'success',       // optional: new conclusion
        'completed_at' => '2024-01-01T01:00:00Z',  // optional: completion time
        'output' => [                    // optional: updated output
            'title' => 'Updated Results',
            'summary' => 'Final test results',
            'text' => 'Updated test details...'
        ],
        'actions' => [                   // optional: action buttons
            [
                'label' => 'Fix',
                'description' => 'Automatically fix issues',
                'identifier' => 'fix_issues'
            ]
        ]
    ]
);
```

## Error Handling

All methods will throw an Exception with the GitHub API error message if the request fails. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $checkRun = Github::checkRuns()->createCheckRun(
        'owner/repo',
        'test-suite',
        'commit-sha'
    );
} catch (\Exception $e) {
    // Handle the error
    echo 'Failed to create check run: ' . $e->getMessage();
}
```

## Response Format

All methods return the raw JSON response from the GitHub API as an array. The structure includes:

```json
{
  "id": 12345,
  "head_sha": "abc123...",
  "node_id": "MDg6Q2hlY2tSdW4xMjM=",
  "external_id": "",
  "url": "https://api.github.com/repos/owner/repo/check-runs/12345",
  "html_url": "https://github.com/owner/repo/runs/12345",
  "status": "completed",
  "conclusion": "success",
  "started_at": "2024-01-01T00:00:00Z",
  "completed_at": "2024-01-01T01:00:00Z",
  "output": {
    "title": "Test Results",
    "summary": "All tests passed",
    "text": "Detailed test results...",
    "annotations_count": 0,
    "annotations_url": "https://api.github.com/repos/owner/repo/check-runs/12345/annotations"
  },
  "name": "test-suite",
  "check_suite": {
    "id": 54321
  },
  "app": {
    "id": 1,
    "slug": "github-actions",
    "name": "GitHub Actions"
  }
}
```

## Best Practices

1. **Status Management**

   - Keep check run status updated in real-time
   - Set appropriate conclusions based on results
   - Include detailed output for debugging

2. **Output Organization**

   - Provide clear, concise titles
   - Include detailed summaries
   - Use annotations for specific code issues
   - Format output text for readability

3. **Performance**

   - Update check runs efficiently
   - Batch annotations when possible
   - Use pagination for listing check runs

4. **Error Handling**

   - Implement proper error handling
   - Provide meaningful error messages
   - Handle rate limits appropriately

5. **Integration**

   - Coordinate with CI/CD pipelines
   - Integrate with GitHub Actions
   - Link to external build systems

6. **Documentation**
   - Document check run meanings
   - Explain conclusion criteria
   - Provide troubleshooting guides

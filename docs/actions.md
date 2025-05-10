# GitHub Actions API

The GitHub Actions API allows you to manage GitHub Actions workflows in your repositories, including listing workflows, viewing runs, re-running workflows, and downloading logs.

## Installation

The Actions API is included in the Laravel GitHub API package. Make sure you have the package installed and configured:

```php
use JuniYadi\GitHub\Facades\Github;
```

## Available Methods

### List Workflows

Get a list of all workflows in a repository.

```php
$workflows = Github::actions()->getWorkflows('owner/repo');
```

The response includes all workflow files found in the `.github/workflows` directory of your repository.

### List Workflow Runs

Get a list of all runs for a specific workflow.

```php
$runs = Github::actions()->getWorkflowRuns(
    'owner/repo',
    'workflow_id',    // Workflow ID or file name (e.g., 'main.yml')
    [
        'branch' => 'main',        // optional: filter by branch
        'event' => 'push',         // optional: filter by event type
        'status' => 'completed',   // optional: filter by status
        'per_page' => 30,         // optional: results per page (max 100)
        'page' => 1               // optional: page number
    ]
);
```

Common event types:

- `push`: Triggered by a push to the repository
- `pull_request`: Triggered by pull request activity
- `schedule`: Triggered by a scheduled event
- `workflow_dispatch`: Manually triggered workflow

Status values:

- `queued`: Run is queued
- `in_progress`: Run is currently in progress
- `completed`: Run has completed
- `failure`: Run has failed
- `success`: Run has succeeded

### Re-run Workflow

Re-run a specific workflow run.

```php
$result = Github::actions()->rerunWorkflow(
    'owner/repo',
    'run_id'        // The ID of the workflow run to re-run
);
```

This is useful when you need to retry a failed workflow run or re-run a workflow with updated inputs.

### Download Workflow Run Logs

Download the logs for a specific workflow run.

```php
$logs = Github::actions()->getWorkflowRunLogs(
    'owner/repo',
    'run_id'        // The ID of the workflow run
);
```

## Error Handling

All methods will throw an Exception with the GitHub API error message if the request fails. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $workflows = Github::actions()->getWorkflows('owner/repo');
} catch (\Exception $e) {
    // Handle the error
    echo 'Failed to fetch workflows: ' . $e->getMessage();
}
```

## Response Format

All methods return the raw JSON response from the GitHub API as an array. The structure varies by endpoint:

### Workflow List Response

```json
{
  "total_count": 2,
  "workflows": [
    {
      "id": 123456,
      "name": "CI",
      "path": ".github/workflows/ci.yml",
      "state": "active",
      "created_at": "2023-01-01T00:00:00Z",
      "updated_at": "2023-01-01T00:00:00Z",
      "url": "https://api.github.com/repos/owner/repo/actions/workflows/123456"
    }
  ]
}
```

### Workflow Runs Response

```json
{
  "total_count": 1,
  "workflow_runs": [
    {
      "id": 789012,
      "name": "CI",
      "head_branch": "main",
      "head_sha": "abc123...",
      "status": "completed",
      "conclusion": "success",
      "event": "push",
      "run_number": 12,
      "created_at": "2023-01-01T00:00:00Z",
      "updated_at": "2023-01-01T00:00:00Z"
    }
  ]
}
```

## Best Practices

1. **Error Handling**

   - Always implement proper error handling
   - Consider rate limits when making multiple requests

2. **Workflow Management**

   - Monitor workflow run status regularly
   - Clean up old workflow runs to maintain repository health
   - Use appropriate filters when listing workflow runs

3. **Log Management**

   - Download and store important workflow logs
   - Implement log rotation for stored logs
   - Parse logs for important information or errors

4. **Performance**
   - Use pagination when fetching large numbers of workflow runs
   - Cache workflow information when appropriate
   - Batch operations when possible

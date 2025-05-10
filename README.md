# Laravel GitHub API Package

A modular, testable, and Laravel-friendly package for interacting with the GitHub API. Provides clean separation of concerns and easy integration via Laravel facades and service providers.

## Features

- Modular API classes: User, Repo, Org, Issues, Pull Requests, Releases, Search, Webhooks, Actions, Projects, Teams, Gists, Check Runs
- Laravel Facade for static access
- Service provider for easy configuration
- PSR-4 autoloading and contracts for testability

## Available Methods

### User API

| Method | Description                           |
| ------ | ------------------------------------- |
| `me`   | Get authenticated user information    |
| `show` | Get information about a specific user |

### Repository API

| Method            | Description                                       |
| ----------------- | ------------------------------------------------- |
| `getRepositories` | List repositories for a user                      |
| `getBranches`     | List branches for a repository                    |
| `show`            | Show repository or file details                   |
| `upload`          | Upload a file to a repository                     |
| `uploadBulk`      | Upload multiple files to a repository             |
| `uploadBulkBlob`  | Bulk upload with single commit using Git Data API |
| `delete`          | Delete a file from a repository                   |
| `deleteBulk`      | Delete multiple files from a repository           |
| `deleteBulkBlob`  | Delete multiple files with single commit          |

### Organization API

| Method                        | Description                           |
| ----------------------------- | ------------------------------------- |
| `getOrganizationRepositories` | List repositories for an organization |
| `show`                        | Get information about an organization |

### Issues API

| Method               | Description                 |
| -------------------- | --------------------------- |
| `getIssues`          | List issues in a repository |
| `createIssue`        | Create a new issue          |
| `updateIssue`        | Update an existing issue    |
| `getIssueComments`   | Get comments on an issue    |
| `createIssueComment` | Comment on an issue         |

### Pull Requests API

| Method                | Description              |
| --------------------- | ------------------------ |
| `getPullRequests`     | List PRs in a repository |
| `createPullRequest`   | Create a new PR          |
| `updatePullRequest`   | Update a PR              |
| `mergePullRequest`    | Merge a PR               |
| `getPullRequestFiles` | List files in a PR       |

### Releases API

| Method          | Description                    |
| --------------- | ------------------------------ |
| `getReleases`   | List releases for a repository |
| `getRelease`    | Get a single release           |
| `createRelease` | Create a release               |
| `updateRelease` | Update a release               |
| `deleteRelease` | Delete a release               |

### Search API

| Method               | Description                     |
| -------------------- | ------------------------------- |
| `searchRepositories` | Search repositories             |
| `searchCode`         | Search code                     |
| `searchUsers`        | Search users                    |
| `searchIssues`       | Search issues and pull requests |

### Webhooks API

| Method          | Description                    |
| --------------- | ------------------------------ |
| `getWebhooks`   | List webhooks for a repository |
| `createWebhook` | Create a webhook               |
| `updateWebhook` | Update a webhook               |
| `deleteWebhook` | Delete a webhook               |

### Actions API

| Method               | Description                    |
| -------------------- | ------------------------------ |
| `getWorkflows`       | List workflows in a repository |
| `getWorkflowRuns`    | List workflow runs             |
| `rerunWorkflow`      | Re-run a workflow              |
| `getWorkflowRunLogs` | Download workflow logs         |

### Projects API

| Method          | Description                       |
| --------------- | --------------------------------- |
| `getProjects`   | List projects for a repo/org/user |
| `createProject` | Create a project                  |
| `updateProject` | Update a project                  |
| `deleteProject` | Delete a project                  |

### Teams API

| Method           | Description                   |
| ---------------- | ----------------------------- |
| `getTeams`       | List teams in an organization |
| `createTeam`     | Create a team                 |
| `updateTeam`     | Update a team                 |
| `deleteTeam`     | Delete a team                 |
| `getTeamMembers` | List team members             |
| `addTeamMember`  | Add a team member             |

### Gists API

| Method       | Description                       |
| ------------ | --------------------------------- |
| `getGists`   | List gists for authenticated user |
| `createGist` | Create a gist                     |
| `updateGist` | Update a gist                     |
| `deleteGist` | Delete a gist                     |

### Check Runs API

| Method           | Description                    |
| ---------------- | ------------------------------ |
| `getCheckRuns`   | Get check runs for a reference |
| `createCheckRun` | Create a check run             |
| `updateCheckRun` | Update a check run             |

## Installation

```bash
composer require juniyadi/laravel-github-api
```

Publish the config file:

```bash
php artisan vendor:publish --provider="JuniYadi\GitHub\Providers\LaravelGithubServiceProvider" --tag=config
```

Set your GitHub token in `config/github.php` or your `.env`:

```
GITHUB_TOKEN=your_github_token
```

## Usage

### Facade Example

```php
use JuniYadi\GitHub\Facades\Github;

// User operations
$user = Github::user()->me();
$repos = Github::repo()->getRepositories('octocat');
$orgRepos = Github::org()->getOrganizationRepositories('laravel');

// Repository content
$file = Github::repo()->show('octocat', 'Hello-World');
// Read Readme file
$file = Github::repo()->show('octocat', 'Hello-World', 'README.md');

// Issues and PRs
$issues = Github::issues()->getIssues('owner/repo');
$pr = Github::pullRequest()->createPullRequest('owner/repo', 'title', 'head', 'base', 'body');

// Other operations
$releases = Github::release()->getReleases('owner/repo');
$searchResults = Github::search()->searchRepositories('language:php stars:>1000');
$workflows = Github::actions()->getWorkflows('owner/repo');
```

### Dependency Injection Example

```php
use JuniYadi\GitHub\Github;

public function __construct(Github $github) {
    $this->github = $github;
}

public function show() {
    return $this->github->user()->me();
}
```

## Documentation

### Bulk File Operations

```php
use JuniYadi\GitHub\Facades\Github;

// Upload multiple files in a single commit
$files = [
    [
        'file' => 'path/to/file1.txt',
        'content' => 'File 1 content'
    ],
    [
        'file' => 'path/to/file2.txt',
        'content' => 'File 2 content'
    ]
];

// Upload files with a single commit
$result = Github::repo()->uploadBulkBlob('owner/repo', 'main', $files, 'Bulk upload commit message');

// Delete multiple files or directories in a single commit
$filesToDelete = [
    'path/to/file1.txt',
    'path/to/directory',  // Will delete directory and all contents
    'path/to/file2.txt'
];

$result = Github::repo()->deleteBulkBlob('owner/repo', 'main', $filesToDelete, 'Bulk delete commit message');
```

See the `docs/` directory for detailed usage of each API class.

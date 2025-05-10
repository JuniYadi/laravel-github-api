# Laravel GitHub API Package

A modular, testable, and Laravel-friendly package for interacting with the GitHub API. Provides clean separation of concerns and easy integration via Laravel facades and service providers.

## Features

-   Modular API classes: User, Repo, Org, Content
-   Laravel Facade for static access
-   Service provider for easy configuration
-   PSR-4 autoloading and contracts for testability

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

$user = Github::user()->me();
$repos = Github::repo()->getRepositories('octocat');
$orgRepos = Github::org()->getOrganizationRepositories('laravel');
$file = Github::content()->getFileContent('octocat', 'Hello-World', 'README.md');
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

See the `docs/` directory for detailed usage of each API class.

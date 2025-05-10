# Search API

The Search API allows you to search through GitHub's repositories, code, users, and issues/pull requests using powerful search qualifiers.

## Installation

The Search API is included in the Laravel GitHub API package. Make sure you have the package installed and configured:

```php
use JuniYadi\GitHub\Facades\Github;
```

## Available Methods

### Search Repositories

Search for repositories matching specific criteria.

```php
$repositories = Github::search()->searchRepositories(
    'laravel language:php stars:>1000',  // search query
    [
        'sort' => 'stars',      // optional: stars, forks, help-wanted-issues, updated
        'order' => 'desc',      // optional: desc or asc
        'per_page' => 30,       // optional: results per page (max 100)
        'page' => 1            // optional: page number
    ]
);
```

Example search qualifiers:

- `language:php`: Filter by programming language
- `stars:>1000`: Repositories with more than 1000 stars
- `created:>2023-01-01`: Created after January 1, 2023
- `user:username`: Repositories by a specific user
- `org:organization`: Repositories in a specific organization

### Search Code

Search for code matching specific text or qualifiers.

```php
$code = Github::search()->searchCode(
    'addClass in:file language:js repo:jquery/jquery',  // search query
    [
        'sort' => 'indexed',    // optional: indexed or default
        'order' => 'desc',      // optional: desc or asc
        'per_page' => 30,       // optional: results per page (max 100)
        'page' => 1            // optional: page number
    ]
);
```

Example search qualifiers:

- `in:file`: Search in file contents
- `in:path`: Search in file path
- `extension:js`: Filter by file extension
- `size:>1000`: Files larger than 1000 bytes
- `repo:owner/repo`: Search in specific repository

### Search Users

Search for users and organizations.

```php
$users = Github::search()->searchUsers(
    'location:london language:php followers:>100',  // search query
    [
        'sort' => 'followers',  // optional: followers, repositories, joined
        'order' => 'desc',      // optional: desc or asc
        'per_page' => 30,       // optional: results per page (max 100)
        'page' => 1            // optional: page number
    ]
);
```

Example search qualifiers:

- `type:user`: Search only users
- `type:org`: Search only organizations
- `location:city`: Filter by location
- `followers:>100`: Users with more than 100 followers
- `created:>2023-01-01`: Accounts created after January 1, 2023

### Search Issues and Pull Requests

Search through issues and pull requests.

```php
$issues = Github::search()->searchIssues(
    'is:open label:bug language:php',  // search query
    [
        'sort' => 'created',    // optional: created, updated, comments
        'order' => 'desc',      // optional: desc or asc
        'per_page' => 30,       // optional: results per page (max 100)
        'page' => 1            // optional: page number
    ]
);
```

Example search qualifiers:

- `type:issue`: Search only issues
- `type:pr`: Search only pull requests
- `is:open`: Open issues/PRs
- `is:closed`: Closed issues/PRs
- `label:bug`: Issues with specific label
- `author:username`: Created by specific user
- `assignee:username`: Assigned to specific user

## Error Handling

All methods will throw an Exception with the GitHub API error message if the request fails. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $results = Github::search()->searchRepositories('laravel stars:>1000');
} catch (\Exception $e) {
    // Handle the error
    echo 'Search failed: ' . $e->getMessage();
}
```

## Response Format

All search methods return the raw JSON response from the GitHub API as an array. The response includes:

### Common Fields

- `total_count`: Total number of matches
- `incomplete_results`: Whether the results are incomplete (rate limit hit)
- `items`: Array of matching items

### Repository Search Results

- Repository name, description, and URL
- Stars, forks, and watchers count
- Primary language
- Owner information

### Code Search Results

- File name and path
- Repository information
- Code snippet with matching terms
- Line numbers

### User Search Results

- Username and display name
- Avatar URL
- Profile information
- Follower and repository counts

### Issue/PR Search Results

- Title and body
- State (open/closed)
- Labels and assignees
- Created and updated timestamps
- Repository information

## Rate Limiting

The Search API has stricter rate limits than other GitHub APIs. To avoid hitting rate limits:

- Use specific search queries to reduce result set
- Implement pagination to retrieve results in smaller chunks
- Cache results when possible
- Handle rate limit errors gracefully

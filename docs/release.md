# Releases API

The Releases API allows you to list, create, update, and delete releases in a repository. Releases are deployable software iterations you can package and make available for others to download.

## Installation

The Releases API is included in the Laravel GitHub API package. Make sure you have the package installed and configured:

```php
use JuniYadi\GitHub\Facades\Github;
```

## Available Methods

### List Releases

Get a list of releases for a repository.

```php
$releases = Github::release()->getReleases('owner/repo', [
    'per_page' => 30,     // optional: results per page (max 100)
    'page' => 1           // optional: page number
]);
```

### Get Single Release

Get details about a specific release.

```php
$release = Github::release()->getRelease('owner/repo', 12345); // release_id
```

### Create Release

Create a new release.

```php
$release = Github::release()->createRelease(
    'owner/repo',
    'v1.0.0',    // tag_name (required)
    [
        'target_commitish' => 'main',     // optional: branch/commit SHA
        'name' => 'Release v1.0.0',       // optional: release title
        'body' => 'Release description',   // optional: release notes
        'draft' => false,                 // optional: true for draft release
        'prerelease' => false            // optional: true for prerelease
    ]
);
```

### Update Release

Update an existing release.

```php
$updatedRelease = Github::release()->updateRelease(
    'owner/repo',
    12345,      // release_id
    [
        'tag_name' => 'v1.0.1',
        'name' => 'Updated Release Title',
        'body' => 'Updated release description',
        'draft' => false,
        'prerelease' => false
    ]
);
```

### Delete Release

Delete a release.

```php
$result = Github::release()->deleteRelease('owner/repo', 12345); // release_id
```

## Error Handling

All methods will throw an Exception with the GitHub API error message if the request fails. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $release = Github::release()->createRelease(
        'owner/repo',
        'v1.0.0',
        [
            'name' => 'Release v1.0.0',
            'body' => 'Release description'
        ]
    );
} catch (\Exception $e) {
    // Handle the error
    echo 'Failed to create release: ' . $e->getMessage();
}
```

## Response Format

All methods return the raw JSON response from the GitHub API as an array. The exact structure depends on the endpoint, but common fields include:

- `id`: The release ID
- `tag_name`: The name of the tag
- `target_commitish`: The branch or commit SHA the tag is based on
- `name`: The release title
- `body`: The release description/notes
- `draft`: Whether this is a draft release
- `prerelease`: Whether this is a pre-release
- `created_at`: Creation timestamp
- `published_at`: Publication timestamp
- `author`: Information about the release author
- `assets`: Array of release assets (downloadable files)
  - `name`: Asset filename
  - `size`: File size in bytes
  - `download_count`: Number of downloads
  - `browser_download_url`: Direct download URL

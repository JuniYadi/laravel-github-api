# RepoApi Usage

Provides repository-related endpoints for managing GitHub repository content.

## Methods

### getRepositories($username, array $options = [])

Returns repositories for a user.

```php
// Basic usage - get all repositories for a user
$repos = Github::repo()->getRepositories('octocat');

// With options - get only repositories owned by the user, sorted by creation date
$repos = Github::repo()->getRepositories('octocat', [
    'type' => 'owner',
    'sort' => 'created',
    'direction' => 'desc',
    'per_page' => 10,
    'page' => 1
]);

// Output example
[
    [
        'id' => 123456789,
        'node_id' => 'MDEwOlJlcG9zaXRvcnkxMjM0NTY3ODk=',
        'name' => 'example-repo',
        'full_name' => 'octocat/example-repo',
        'private' => false,
        'html_url' => 'https://github.com/octocat/example-repo',
        // More repository properties...
    ],
    // More repositories...
]
```

#### Options

-   type: all, owner, member
-   sort: created, updated, pushed, full_name
-   direction: asc, desc
-   per_page: int
-   page: int

### getBranches($repo, array $options = [])

Returns branches for a repository.

```php
// Basic usage - get all branches for a repository
$branches = Github::repo()->getBranches('octocat/example-repo');

// With pagination options
$branches = Github::repo()->getBranches('octocat/example-repo', [
    'per_page' => 10,
    'page' => 1
]);

// Output example
[
    [
        'name' => 'main',
        'commit' => [
            'sha' => 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
            'url' => 'https://api.github.com/repos/octocat/example-repo/commits/a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0'
        ],
        'protected' => true
    ],
    [
        'name' => 'development',
        'commit' => [
            'sha' => 'b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1',
            'url' => 'https://api.github.com/repos/octocat/example-repo/commits/b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1'
        ],
        'protected' => false
    ],
    // More branches...
]
```

### show($repo, $file = null, array $options = [])

Shows repository details or gets contents of a file.

```php
// Get repository details
$repoDetails = Github::repo()->show('octocat/example-repo');

// Get content of a specific file
$fileContent = Github::repo()->show('octocat/example-repo', 'README.md');

// With reference to a specific branch
$fileContent = Github::repo()->show('octocat/example-repo', 'README.md', [
    'ref' => 'development'
]);

// Output example for a file
[
    'type' => 'file',
    'encoding' => 'base64',
    'size' => 5362,
    'name' => 'README.md',
    'path' => 'README.md',
    'content' => 'IyBFeGFtcGxlIFJlcG9zaXRvcnkKCkEgc2ltcGxlIGV4YW1wbGUgcmVwb3NpdG9yeS4=', // Base64 encoded
    'sha' => 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
    'url' => 'https://api.github.com/repos/octocat/example-repo/contents/README.md',
    'git_url' => 'https://api.github.com/repos/octocat/example-repo/git/blobs/a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
    'html_url' => 'https://github.com/octocat/example-repo/blob/main/README.md',
    'download_url' => 'https://raw.githubusercontent.com/octocat/example-repo/main/README.md'
]
```

### upload($repo, $file, $message, $content, array $options = [])

Uploads a file to a repository.

```php
// Upload a new file
$result = Github::repo()->upload(
    'octocat/example-repo',
    'docs/example.md',
    'Add example documentation',
    '# Example Documentation\n\nThis is an example file.'
);

// Override an existing file using force option
$result = Github::repo()->upload(
    'octocat/example-repo',
    'docs/example.md',
    'Update example documentation',
    '# Example Documentation\n\nThis is an updated example file.',
    ['force' => true]
);

// Upload a file to a specific branch
$result = Github::repo()->upload(
    'octocat/example-repo',
    'docs/example.md',
    'Add example documentation to development branch',
    '# Example Documentation\n\nThis is an example file.',
    ['branch' => 'development']
);

// Output example
[
    'content' => [
        'name' => 'example.md',
        'path' => 'docs/example.md',
        'sha' => 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
        'size' => 51,
        'url' => 'https://api.github.com/repos/octocat/example-repo/contents/docs/example.md',
        'html_url' => 'https://github.com/octocat/example-repo/blob/main/docs/example.md',
        'git_url' => 'https://api.github.com/repos/octocat/example-repo/git/blobs/a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
        'download_url' => 'https://raw.githubusercontent.com/octocat/example-repo/main/docs/example.md',
        'type' => 'file',
        'content' => 'IyBFeGFtcGxlIERvY3VtZW50YXRpb24KClRoaXMgaXMgYW4gZXhhbXBsZSBmaWxlLg==',
        'encoding' => 'base64'
    ],
    'commit' => [
        'sha' => 'b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1',
        'node_id' => 'MDY6Q29tbWl0YjJjM2Q0ZTVmNmc3aDhpOWowa2wxMm0zbjRvNXA2cTdyOHM5dDB1MQ==',
        'url' => 'https://api.github.com/repos/octocat/example-repo/git/commits/b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1',
        'html_url' => 'https://github.com/octocat/example-repo/commit/b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1',
        'author' => [
            'name' => 'Octocat',
            'email' => 'octocat@github.com',
            'date' => '2025-05-10T12:34:56Z'
        ],
        'committer' => [
            'name' => 'Octocat',
            'email' => 'octocat@github.com',
            'date' => '2025-05-10T12:34:56Z'
        ],
        'tree' => [
            'sha' => 'c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2',
            'url' => 'https://api.github.com/repos/octocat/example-repo/git/trees/c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2'
        ],
        'message' => 'Add example documentation',
        'parents' => [
            [
                'sha' => 'd4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3',
                'url' => 'https://api.github.com/repos/octocat/example-repo/git/commits/d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3',
                'html_url' => 'https://github.com/octocat/example-repo/commit/d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3'
            ]
        ],
        'verification' => [
            'verified' => false,
            'reason' => 'unsigned',
            'signature' => null,
            'payload' => null
        ]
    ]
]
```

### uploadBulk($repo, array $files, array $options = [])

Uploads multiple files to a repository.

```php
// Upload multiple files
$results = Github::repo()->uploadBulk(
    'octocat/example-repo',
    [
        [
            'file' => 'docs/example.md',
            'message' => 'Add example documentation',
            'content' => '# Example Documentation\n\nThis is an example file.'
        ],
        [
            'file' => 'docs/guide.md',
            'message' => 'Add guide documentation',
            'content' => '# Guide\n\nThis is a guide document.'
        ]
    ],
    ['force' => true] // Override existing files
);

// Output example - array of upload results for each file
[
    [
        'content' => [
            'name' => 'example.md',
            'path' => 'docs/example.md',
            // More content details...
        ],
        'commit' => [
            'sha' => 'b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1',
            // More commit details...
        ]
    ],
    [
        'content' => [
            'name' => 'guide.md',
            'path' => 'docs/guide.md',
            // More content details...
        ],
        'commit' => [
            'sha' => 'c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2',
            // More commit details...
        ]
    ]
]
```

### uploadBulkBlob($repo, $branch, array $files, $message)

Uploads multiple files to a repository using Git Data API (more efficient for bulk uploads).

```php
// Upload multiple files with a single commit
$result = Github::repo()->uploadBulkBlob(
    'octocat/example-repo',
    'main', // Target branch
    [
        [
            'file' => 'docs/example.md',
            'content' => '# Example Documentation\n\nThis is an example file.'
        ],
        [
            'file' => 'docs/guide.md',
            'content' => '# Guide\n\nThis is a guide document.'
        ]
    ],
    'Add documentation files' // Single commit message for all files
);

// Output example
[
    'commit' => [
        'sha' => 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
        'node_id' => 'MDY6Q29tbWl0YTFiMmMzZDRlNWY2ZzdoOGk5ajBrMWwybTNuNG81cDZxN3I4czl0MA==',
        // More commit details...
    ],
    'tree' => [
        'sha' => 'b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1',
        // More tree details...
    ],
    'files' => [
        [
            'file' => 'docs/example.md',
            'content' => '# Example Documentation\n\nThis is an example file.'
        ],
        [
            'file' => 'docs/guide.md',
            'content' => '# Guide\n\nThis is a guide document.'
        ]
    ],
    'changed' => true
]
```

### delete($repo, $file, $message, array $options = [])

Deletes a file from a repository.

```php
// Delete a file
$result = Github::repo()->delete(
    'octocat/example-repo',
    'docs/example.md',
    'Remove example documentation'
);

// Delete a file from a specific branch
$result = Github::repo()->delete(
    'octocat/example-repo',
    'docs/example.md',
    'Remove example documentation from development branch',
    ['branch' => 'development']
);

// Output example
[
    'content' => null,
    'commit' => [
        'sha' => 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
        'node_id' => 'MDY6Q29tbWl0YTFiMmMzZDRlNWY2ZzdoOGk5ajBrMWwybTNuNG81cDZxN3I4czl0MA==',
        'url' => 'https://api.github.com/repos/octocat/example-repo/git/commits/a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
        'html_url' => 'https://github.com/octocat/example-repo/commit/a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
        'author' => [
            'name' => 'Octocat',
            'email' => 'octocat@github.com',
            'date' => '2025-05-10T12:34:56Z'
        ],
        // More commit details...
    ]
]
```

### deleteBulk($repo, array $files, array $options = [])

Deletes multiple files from a repository.

```php
// Delete multiple files
$results = Github::repo()->deleteBulk(
    'octocat/example-repo',
    [
        [
            'file' => 'docs/example.md',
            'message' => 'Remove example documentation'
        ],
        [
            'file' => 'docs/guide.md',
            'message' => 'Remove guide documentation'
        ]
    ],
    ['branch' => 'main'] // Optional parameters
);

// Output example
[
    [
        'file' => 'docs/example.md',
        'status' => 'deleted',
        'response' => [
            'content' => null,
            'commit' => [
                'sha' => 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
                // More commit details...
            ]
        ]
    ],
    [
        'file' => 'docs/guide.md',
        'status' => 'deleted',
        'response' => [
            'content' => null,
            'commit' => [
                'sha' => 'b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1',
                // More commit details...
            ]
        ]
    ]
]
```

### deleteBulkBlob($repo, $branch, array $files, $message, array $options = [])

Deletes multiple files or directories from a repository using Git Data API (more efficient for bulk deletions).

```php
// Delete multiple files with a single commit
$result = Github::repo()->deleteBulkBlob(
    'octocat/example-repo',
    'main', // Target branch
    [
        'docs/example.md',
        'docs/guide.md',
        'images/logo/' // Delete an entire directory
    ],
    'Remove documentation and logo files',
    [] // Optional parameters
);

// Output example
[
    'success' => true,
    'commit' => [
        'sha' => 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0',
        // More commit details...
    ],
    'tree' => [
        'sha' => 'b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1',
        // More tree details...
    ],
    'files' => [
        'docs/example.md',
        'docs/guide.md',
        'images/logo/'
    ],
    'deleted_paths' => [
        'docs/example.md',
        'docs/guide.md',
        'images/logo/logo.png',
        'images/logo/logo-small.png'
    ],
    'changed' => true
]
```

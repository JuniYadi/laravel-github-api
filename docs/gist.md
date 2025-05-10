# Gists API

The Gists API allows you to manage GitHub Gists - snippets of code or text that can be shared publicly or privately. You can create, update, list, and delete gists using this API.

## Installation

The Gists API is included in the Laravel GitHub API package. Make sure you have the package installed and configured:

```php
use JuniYadi\GitHub\Facades\Github;
```

## Available Methods

### List Gists

Get a list of gists for the authenticated user.

```php
$gists = Github::gist()->getGists([
    'since' => '2024-01-01T00:00:00Z',  // optional: ISO 8601 timestamp
    'per_page' => 30,                    // optional: results per page (max 100)
    'page' => 1                         // optional: page number
]);
```

### Create Gist

Create a new gist with one or more files.

```php
$gist = Github::gist()->createGist(
    [
        'example.php' => [
            'content' => '<?php echo "Hello World!";'
        ],
        'notes.md' => [
            'content' => '# Notes\n\nThis is a sample note.'
        ]
    ],
    'Example Gist Description',  // optional description
    false                       // optional: public (true) or secret (false)
);
```

File Format:

```php
[
    'filename' => [
        'content' => 'file content here'
    ],
    // Additional files...
]
```

### Update Gist

Update an existing gist's files and/or description.

```php
$updatedGist = Github::gist()->updateGist(
    'gist_id',
    [
        'example.php' => [
            'content' => '<?php echo "Updated content";'
        ],
        'new_file.txt' => [
            'content' => 'New file content'
        ],
        'file_to_delete.txt' => null  // Delete this file
    ],
    [
        'description' => 'Updated description'  // optional
    ]
);
```

To modify files in a gist:

- Add new files by including them in the files array
- Update existing files by providing new content
- Delete files by setting their content to null

### Delete Gist

Delete a gist.

```php
$result = Github::gist()->deleteGist('gist_id');
```

## Error Handling

All methods will throw an Exception with the GitHub API error message if the request fails. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $gist = Github::gist()->createGist(
        ['file.txt' => ['content' => 'Content here']],
        'My Gist'
    );
} catch (\Exception $e) {
    // Handle the error
    echo 'Failed to create gist: ' . $e->getMessage();
}
```

## Response Format

All methods return the raw JSON response from the GitHub API as an array. The structure varies by endpoint:

### Gist Object Format

```json
{
  "id": "gist_id",
  "description": "Gist description",
  "public": false,
  "owner": {
    "login": "username",
    "id": 123456
  },
  "files": {
    "example.php": {
      "filename": "example.php",
      "type": "application/x-php",
      "language": "PHP",
      "raw_url": "https://gist.githubusercontent.com/raw/...",
      "size": 123,
      "content": "<?php echo 'Hello World!';"
    }
  },
  "created_at": "2024-01-01T00:00:00Z",
  "updated_at": "2024-01-01T00:00:00Z",
  "html_url": "https://gist.github.com/...",
  "git_pull_url": "https://gist.github.com/....git",
  "git_push_url": "https://gist.github.com/....git"
}
```

## Best Practices

1. **File Management**

   - Use descriptive filenames
   - Include appropriate file extensions
   - Keep file sizes reasonable
   - Use appropriate file organization

2. **Privacy**

   - Consider visibility settings (public vs. secret)
   - Don't store sensitive information in gists
   - Use secret gists for private code snippets

3. **Content Organization**

   - Provide clear descriptions
   - Use appropriate file names and extensions
   - Include comments in code files
   - Group related files together

4. **Performance**

   - Use pagination when listing gists
   - Keep file sizes manageable
   - Cache gist information when appropriate

5. **Security**

   - Never store sensitive data in gists
   - Review gist contents before making public
   - Regular audit of gist visibility
   - Use appropriate authentication

6. **Maintenance**
   - Regularly update outdated gists
   - Remove unnecessary gists
   - Keep descriptions up to date
   - Monitor gist comments and feedback

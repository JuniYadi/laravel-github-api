# Projects API

The Projects API allows you to manage GitHub Projects for repositories, organizations, and users. Projects help you organize and track your work using boards, lists, and cards.

## Installation

The Projects API is included in the Laravel GitHub API package. Make sure you have the package installed and configured:

```php
use JuniYadi\GitHub\Facades\Github;
```

## Available Methods

### List Projects

Get a list of projects for a repository, organization, or user.

```php
// For a repository
$repoProjects = Github::project()->getProjects(
    'owner/repo',
    'repos',
    [
        'state' => 'open',     // optional: open or closed
        'per_page' => 30,      // optional: results per page (max 100)
        'page' => 1           // optional: page number
    ]
);

// For an organization
$orgProjects = Github::project()->getProjects(
    'organization-name',
    'orgs',
    [
        'state' => 'all'      // optional: all, open, or closed
    ]
);

// For a user
$userProjects = Github::project()->getProjects(
    'username',
    'users'
);
```

### Create Project

Create a new project for a repository, organization, or user.

```php
$project = Github::project()->createProject(
    'owner/repo',                          // owner name or repo full name
    'repos',                               // type: 'repos', 'orgs', or 'users'
    'New Project',                         // project name
    'Project description goes here',       // project body/description
    [
        'organization_permission' => 'read' // optional: org permission level
    ]
);
```

Organization permission levels (when type is 'orgs'):

- `read`: Read-only access
- `write`: Read and write access
- `admin`: Full administrative access
- `none`: No access

### Update Project

Update an existing project's properties.

```php
$updatedProject = Github::project()->updateProject(
    12345,      // project_id
    [
        'name' => 'Updated Project Name',
        'body' => 'Updated project description',
        'state' => 'closed',    // open or closed
        'private' => true       // visibility setting
    ]
);
```

### Delete Project

Delete a project.

```php
$result = Github::project()->deleteProject(12345); // project_id
```

## Error Handling

All methods will throw an Exception with the GitHub API error message if the request fails. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $project = Github::project()->createProject(
        'owner/repo',
        'repos',
        'New Project',
        'Project description'
    );
} catch (\Exception $e) {
    // Handle the error
    echo 'Failed to create project: ' . $e->getMessage();
}
```

## Response Format

All methods return the raw JSON response from the GitHub API as an array. The structure varies by endpoint:

### Project Object Format

```json
{
  "id": 1234567,
  "node_id": "MDc6UHJvamVjdDEyMzQ1Njc=",
  "name": "Project Name",
  "body": "Project description",
  "number": 1,
  "state": "open",
  "creator": {
    "login": "username",
    "id": 123456,
    "type": "User"
  },
  "created_at": "2023-01-01T00:00:00Z",
  "updated_at": "2023-01-01T00:00:00Z",
  "organization_permission": "write",
  "private": false,
  "html_url": "https://github.com/orgs/owner/projects/1",
  "owner_url": "https://api.github.com/repos/owner/repo"
}
```

## Best Practices

1. **Permission Management**

   - Set appropriate organization permissions when creating projects
   - Regularly audit project access permissions
   - Consider using private projects for sensitive information

2. **Project Organization**

   - Use clear, descriptive names for projects
   - Provide detailed descriptions
   - Keep project states updated (open/closed)

3. **Error Handling**

   - Implement proper error handling for all API calls
   - Consider rate limits when making multiple requests
   - Handle permission-related errors appropriately

4. **Performance**

   - Use pagination when listing projects
   - Cache project information when appropriate
   - Batch operations when possible

5. **Project Lifecycle**
   - Archive or delete unused projects
   - Maintain project documentation
   - Regularly review and update project settings

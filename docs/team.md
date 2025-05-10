# Teams API

The Teams API allows you to manage GitHub teams within organizations, including creating and updating teams, managing team membership, and organizing team permissions.

## Installation

The Teams API is included in the Laravel GitHub API package. Make sure you have the package installed and configured:

```php
use JuniYadi\GitHub\Facades\Github;
```

## Available Methods

### List Teams

Get a list of teams in an organization.

```php
$teams = Github::team()->getTeams(
    'organization-name',
    [
        'per_page' => 30,      // optional: results per page (max 100)
        'page' => 1,           // optional: page number
        'privacy' => 'closed'  // optional: secret or closed
    ]
);
```

### Create Team

Create a new team in an organization.

```php
$team = Github::team()->createTeam(
    'organization-name',
    'team-name',
    [
        'description' => 'Team description',
        'privacy' => 'closed',          // optional: secret or closed
        'permission' => 'pull',         // optional: pull, push, or admin
        'parent_team_id' => null,      // optional: ID of parent team for nested teams
        'repo_names' => [              // optional: repositories to add
            'org/repo1',
            'org/repo2'
        ]
    ]
);
```

Permission levels:

- `pull`: Read-only access to repositories
- `push`: Read and write access to repositories
- `admin`: Administrative access to repositories

Privacy settings:

- `secret`: Only visible to organization owners and team members
- `closed`: Visible to all organization members

### Update Team

Update an existing team's settings.

```php
$updatedTeam = Github::team()->updateTeam(
    12345,      // team_id
    [
        'name' => 'New Team Name',
        'description' => 'Updated description',
        'privacy' => 'secret',
        'permission' => 'push',
        'parent_team_id' => 67890  // optional: move team under a parent team
    ]
);
```

### Delete Team

Delete a team from an organization.

```php
$result = Github::team()->deleteTeam(12345); // team_id
```

### List Team Members

Get a list of members in a team.

```php
$members = Github::team()->getTeamMembers(
    12345,      // team_id
    [
        'role' => 'all',       // optional: all, maintainer, or member
        'per_page' => 30,      // optional: results per page (max 100)
        'page' => 1           // optional: page number
    ]
);
```

### Add Team Member

Add a user to a team.

```php
$result = Github::team()->addTeamMember(
    12345,          // team_id
    'username',     // GitHub username
    [
        'role' => 'member'    // optional: member or maintainer
    ]
);
```

## Error Handling

All methods will throw an Exception with the GitHub API error message if the request fails. It's recommended to wrap API calls in try-catch blocks:

```php
try {
    $team = Github::team()->createTeam(
        'organization-name',
        'team-name',
        ['description' => 'Team description']
    );
} catch (\Exception $e) {
    // Handle the error
    echo 'Failed to create team: ' . $e->getMessage();
}
```

## Response Format

All methods return the raw JSON response from the GitHub API as an array. The structure varies by endpoint:

### Team Object Format

```json
{
  "id": 1234567,
  "node_id": "MDQ6VGVhbTEyMzQ1Njc=",
  "name": "Team Name",
  "slug": "team-name",
  "description": "Team description",
  "privacy": "closed",
  "permission": "pull",
  "members_count": 3,
  "repos_count": 10,
  "organization": {
    "login": "org-name",
    "id": 54321
  },
  "html_url": "https://github.com/orgs/org-name/teams/team-name",
  "members_url": "https://api.github.com/teams/1234567/members{/member}",
  "repositories_url": "https://api.github.com/teams/1234567/repos",
  "parent": null
}
```

## Best Practices

1. **Team Structure**

   - Use descriptive team names
   - Provide clear team descriptions
   - Organize teams hierarchically when appropriate
   - Set appropriate privacy levels

2. **Permission Management**

   - Follow the principle of least privilege
   - Regularly audit team permissions
   - Use nested teams for permission inheritance
   - Document permission changes

3. **Team Membership**

   - Keep teams focused and manageable
   - Regularly review team membership
   - Remove inactive members
   - Document membership requirements

4. **Error Handling**

   - Implement proper error handling
   - Handle permission-related errors gracefully
   - Consider rate limits when making multiple requests

5. **Team Organization**

   - Group related teams under parent teams
   - Use consistent naming conventions
   - Maintain team documentation
   - Archive or delete unused teams

6. **Performance**
   - Use pagination when listing teams or members
   - Cache team information when appropriate
   - Batch operations when possible

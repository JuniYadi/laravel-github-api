# OrgApi Usage

Provides organization-related endpoints.

## Methods

### getOrganizationRepositories($org, array $options = [])

Returns repositories for an organization.

```php
$orgRepos = Github::org()->getOrganizationRepositories('laravel');
```

#### Options

-   type: all, public, private, forks, sources, member
-   sort: created, updated, pushed, full_name
-   direction: asc, desc
-   per_page: int
-   page: int

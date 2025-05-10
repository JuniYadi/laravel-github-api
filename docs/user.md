# UserApi Usage

Provides user-related endpoints.

## Methods

### me()

Returns the authenticated user's details.

```php
$user = Github::user()->me();
```

### getUser($username)

Returns details for a specific user.

```php
$user = Github::user()->getUser('octocat');
```

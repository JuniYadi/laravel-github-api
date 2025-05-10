<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\UserApi\Me;
use JuniYadi\GitHub\Api\UserApi\Users;
use JuniYadi\GitHub\Contracts\UserApiInterface;

class UserApi extends ApiBase implements UserApiInterface
{
    use Me, Users;
}

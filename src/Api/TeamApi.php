<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\TeamApi\Teams;
use JuniYadi\GitHub\Contracts\TeamApiInterface;

class TeamApi extends ApiBase implements TeamApiInterface
{
    use Teams;
}
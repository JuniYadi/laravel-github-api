<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\ActionsApi\Workflows;
use JuniYadi\GitHub\Contracts\ActionsApiInterface;

class ActionsApi extends ApiBase implements ActionsApiInterface
{
    use Workflows;
}
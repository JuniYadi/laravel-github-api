<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\OrgApi\Repositories;
use JuniYadi\GitHub\Contracts\OrgApiInterface;

class OrgApi extends ApiBase implements OrgApiInterface
{
    use Repositories;
}

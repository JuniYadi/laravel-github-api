<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\ReleaseApi\Releases;
use JuniYadi\GitHub\Contracts\ReleaseApiInterface;

class ReleaseApi extends ApiBase implements ReleaseApiInterface
{
    use Releases;
}
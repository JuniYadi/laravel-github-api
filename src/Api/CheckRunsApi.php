<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\CheckRunsApi\CheckRuns;
use JuniYadi\GitHub\Contracts\CheckRunsApiInterface;

class CheckRunsApi extends ApiBase implements CheckRunsApiInterface
{
    use CheckRuns;
}
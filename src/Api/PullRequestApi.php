<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\PullRequestApi\PullRequests;
use JuniYadi\GitHub\Contracts\PullRequestApiInterface;

class PullRequestApi extends ApiBase implements PullRequestApiInterface
{
    use PullRequests;
}
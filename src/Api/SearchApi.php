<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\SearchApi\Search;
use JuniYadi\LaravelGithubApi\Contracts\SearchApiInterface;

class SearchApi extends ApiBase implements SearchApiInterface
{
    use Search;
}
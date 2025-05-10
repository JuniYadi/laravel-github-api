<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\GistsApi\Gists;
use JuniYadi\GitHub\Contracts\GistsApiInterface;

class GistsApi extends ApiBase implements GistsApiInterface
{
    use Gists;
}
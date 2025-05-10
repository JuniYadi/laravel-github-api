<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\ProjectApi\Projects;
use JuniYadi\GitHub\Contracts\ProjectApiInterface;

class ProjectApi extends ApiBase implements ProjectApiInterface
{
    use Projects;
}
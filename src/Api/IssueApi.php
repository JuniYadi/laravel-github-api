<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\IssueApi\Issues;
use JuniYadi\GitHub\Api\IssueApi\Comments;
use JuniYadi\GitHub\Contracts\IssueApiInterface;

class IssueApi extends ApiBase implements IssueApiInterface
{
    use Issues, Comments;
}
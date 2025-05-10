<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\RepoApi\Branches;
use JuniYadi\GitHub\Api\RepoApi\Delete;
use JuniYadi\GitHub\Api\RepoApi\Repositories;
use JuniYadi\GitHub\Api\RepoApi\Show;
use JuniYadi\GitHub\Api\RepoApi\Upload;
use JuniYadi\GitHub\Api\RepoApi\UploadBulk;
use JuniYadi\GitHub\Contracts\RepoApiInterface;

class RepoApi extends ApiBase implements RepoApiInterface
{
    use Branches, Delete, Repositories, Show, Upload, UploadBulk;
}

<?php

namespace JuniYadi\GitHub;

use JuniYadi\GitHub\Api\OrgApi;
use JuniYadi\GitHub\Api\RepoApi;
use JuniYadi\GitHub\Api\UserApi;

class Github
{
    protected $token;

    protected $userApi;

    protected $repoApi;

    protected $orgApi;


    public function __construct()
    {
        $this->userApi = new UserApi;
        $this->repoApi = new RepoApi;
        $this->orgApi = new OrgApi;
    }

    /**
     * @return UserApi
     */
    public function user()
    {
        return $this->userApi;
    }

    /**
     * @return RepoApi
     */
    public function repo()
    {
        return $this->repoApi;
    }

    /**
     * @return OrgApi
     */
    public function org()
    {
        return $this->orgApi;
    }
}

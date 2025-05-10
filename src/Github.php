<?php

namespace JuniYadi\GitHub;

use JuniYadi\GitHub\Api\ActionsApi;
use JuniYadi\GitHub\Api\OrgApi;
use JuniYadi\GitHub\Api\RepoApi;
use JuniYadi\GitHub\Api\SearchApi;
use JuniYadi\GitHub\Api\UserApi;
use JuniYadi\GitHub\Api\IssueApi;
use JuniYadi\GitHub\Api\PullRequestApi;
use JuniYadi\GitHub\Api\ReleaseApi;
use JuniYadi\GitHub\Api\WebhookApi;

class Github
{
    protected $token;

    protected $userApi;

    protected $repoApi;

    protected $orgApi;

    protected $issueApi;

    protected $pullRequestApi;

    protected $releaseApi;

    protected $searchApi;

    protected $webhookApi;

    protected $actionsApi;

    public function __construct()
    {
        $this->userApi = new UserApi;
        $this->repoApi = new RepoApi;
        $this->orgApi = new OrgApi;
        $this->issueApi = new IssueApi;
        $this->pullRequestApi = new PullRequestApi;
        $this->releaseApi = new ReleaseApi;
        $this->searchApi = new SearchApi;
        $this->webhookApi = new WebhookApi;
        $this->actionsApi = new ActionsApi;
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

    /**
     * @return IssueApi
     */
    public function issue()
    {
        return $this->issueApi;
    }

    /**
     * @return PullRequestApi
     */
    public function pullRequest()
    {
        return $this->pullRequestApi;
    }

    /**
     * @return ReleaseApi
     */
    public function release()
    {
        return $this->releaseApi;
    }

    /**
     * @return SearchApi
     */
    public function search()
    {
        return $this->searchApi;
    }

    /**
     * @return WebhookApi
     */
    public function webhook()
    {
        return $this->webhookApi;
    }

    /**
     * @return ActionsApi
     */
    public function actions()
    {
        return $this->actionsApi;
    }
}

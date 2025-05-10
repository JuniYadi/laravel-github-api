<?php

namespace JuniYadi\GitHub\Api;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

abstract class ApiBase
{
    protected $token;

    protected $baseUrl = 'https://api.github.com';

    protected $req;

    protected $username;

    public function __construct($token = null)
    {
        $this->token = $token ?: Config::get('github.token');

        if (empty($this->token)) {
            throw new \InvalidArgumentException('GITHUB_TOKEN is required.');
        }

        $this->setRequest($this->token);
    }

    public function setRequest($token = null, $headers = [])
    {
        $this->req = Http::withOptions([
            'debug' => env('GITHUB_DEBUG', false),
        ])
            ->baseUrl($this->baseUrl)
            ->withToken($token)
            ->withHeaders(array_merge(['Accept' => 'application/vnd.github.v3+json'], $headers));
    }

    public function setToken($token)
    {
        $this->token = $token;
        $this->setRequest($token);

        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
}

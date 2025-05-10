<?php

namespace JuniYadi\GitHub\Api\UserApi;

trait Me
{
    public function me()
    {
        $req = $this->req->get('/user');
        $req->throwUnlessStatus(200);

        return $req->json();
    }
}
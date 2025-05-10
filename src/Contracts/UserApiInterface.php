<?php

namespace JuniYadi\GitHub\Contracts;

interface UserApiInterface
{
    public function me();

    public function getUser($username);
}

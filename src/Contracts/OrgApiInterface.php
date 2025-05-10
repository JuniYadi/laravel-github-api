<?php

namespace JuniYadi\GitHub\Contracts;

interface OrgApiInterface
{
    public function repositories($org, array $options = []);
}

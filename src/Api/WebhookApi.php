<?php

namespace JuniYadi\GitHub\Api;

use JuniYadi\GitHub\Api\WebhookApi\Webhooks;
use JuniYadi\GitHub\Contracts\WebhookApiInterface;

class WebhookApi extends ApiBase implements WebhookApiInterface
{
    use Webhooks;
}
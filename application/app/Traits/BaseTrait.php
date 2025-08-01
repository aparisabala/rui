<?php

namespace App\Traits;

use App\Traits\Apis\Sms\ApiSms;
use App\Traits\PxTraits\PxTraits;

trait BaseTrait
{
    //dependacy
    use PxTraits;

    //api
    use ApiSms;
}

<?php

/**
 * Part of Dear package.
 *
 * @package Dear
 * @version 1.0
 * @author Umair Mahmood
 * @license MIT
 * @copyright Copyright (c) 2019 Umair Mahmood
 *
 */

namespace Rocketmen\Dear\Api;

use Rocketmen\Dear\Api\Contracts\PostMethodAllowed as PostContract;
use Rocketmen\Dear\Api\Contracts\PutMethodAllowed as PutContract;

class SaleFulfilmentShip extends BaseApi implements PostContract, PutContract
{
    protected function getGUID()
    {
        return "TaskID";
    }

    protected function getAction()
    {
        return 'sale/fulfilment/ship';
    }
}
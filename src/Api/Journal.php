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

use Rocketmen\Dear\Api\Contracts\DeleteMethodAllowed as DeleteContract;
use Rocketmen\Dear\Api\Contracts\PostMethodAllowed as PostContract;
use Rocketmen\Dear\Api\Contracts\PutMethodAllowed as PutContract;

class Journal extends BaseApi implements PostContract, PutContract, DeleteContract
{
    protected function getGUID()
    {
        return "ID";
    }

    protected function getAction()
    {
        return 'journal';
    }
}
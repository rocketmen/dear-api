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

class AdvancedPurchaseInvoice extends BaseApi implements PostContract, DeleteContract
{
    protected function getGUID()
    {
        return "PurchaseID";
    }

    protected function getAction()
    {
        return 'advanced-purchase/invoice';
    }
}
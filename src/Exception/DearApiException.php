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

namespace Rocketmen\Dear\Exception;

use Exception;

class DearApiException extends Exception
{
    public $statusCode;
    public $responseContent;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getResponseContent()
    {
        return $this->responseContent;
    }

    public function setResponseContent($responseContent)
    {
        $this->responseContent = $responseContent;
    }
}
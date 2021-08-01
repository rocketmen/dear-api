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

namespace Rocketmen\Dear;

class Config
{
    /**
     * @var string
     */
    protected $accountId;

    /**
     * @var string
     */
    protected $applicationKey;

    /**
     * @var bool|string
     */
    protected $verifySSL;

    /**
     * Config constructor.
     * @param string $accountId
     * @param string $applicationKey
     * @param bool|string $verifySSL
     */
    public function __construct($accountId = null, $applicationKey = null, $verifySSL = true)
    {
        $this->setAccountId($accountId ?: getenv('DEAR_ACCOUNT_ID'));
        $this->setApplicationKey($applicationKey ?: getenv('DEAR_APPLICATION_KEY'));
        $this->setVerifySSL($verifySSL);
    }

    /**
     * @return string
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param string $accountId
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * @return string
     */
    public function getApplicationKey()
    {
        return $this->applicationKey;
    }

    /**
     * @param string $applicationKey
     */
    public function setApplicationKey($applicationKey)
    {
        $this->applicationKey = $applicationKey;
    }

    /**
     * @return bool|string
     */
    public function getVerifySSL()
    {
        return $this->verifySSL;
    }

    /**
     * @param bool|string $verifySSL
     */
    public function setVerifySSL($verifySSL)
    {
        $this->verifySSL = $verifySSL;
    }
}
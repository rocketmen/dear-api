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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Rocketmen\Dear\Api\Contracts\DeleteMethodAllowed;
use Rocketmen\Dear\Api\Contracts\PostMethodAllowed;
use Rocketmen\Dear\Api\Contracts\PutMethodAllowed;
use Rocketmen\Dear\Config;
use Rocketmen\Dear\Exception\BadRequestException;
use Rocketmen\Dear\Exception\DearApiException;
use Rocketmen\Dear\Exception\ForbiddenRequestException;
use Rocketmen\Dear\Exception\InternalServerErrorException;
use Rocketmen\Dear\Exception\MethodNotAllowedException;
use Rocketmen\Dear\Exception\NotFoundException;
use Rocketmen\Dear\Exception\ServiceUnavailableException;
use Rocketmen\Dear\Helper;
use Rocketmen\Dear\RESTApi;

abstract class BaseApi implements RESTApi
{
    /**
     * Default limit
     */
    const LIMIT = 100;
    /**
     * Default page
     */
    const PAGE = 1;

    /**
     * HTTP request content type
     */
    const CONTENT_TYPE = 'application/json';

    /**
     * @var Config
     */
    protected $config;

    /**
     * BaseApi constructor.
     * @param $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    final public function get($parameters = [])
    {
        return $this->execute('GET', Helper::prepareParameters($parameters));
    }

    /**
     * @param $httpMethod
     * @param array $parameters
     * @return array
     * @throws GuzzleException
     */
    protected function execute($httpMethod, array $parameters)
    {
        try {
            $requestParams = [
                'headers' => $this->getHeaders()
            ];

            if ($httpMethod == 'POST' || $httpMethod == 'PUT') {
                $requestParams['body'] = json_encode($parameters);
            } else {
                $requestParams['query'] = $parameters;
            }

            $response = $this->getClient()->request($httpMethod, $this->getAction(), $requestParams);
            return \GuzzleHttp\json_decode((string) $response->getBody(), true);
        } catch (ClientException $clientException) {
            return $this->handleClientException($clientException);
        } catch (ServerException $serverException) {
            if ($serverException->getResponse()->getStatusCode() === 503) {
                // API limit exceeded
                sleep(5);

                return $this->execute($httpMethod, $parameters);
            }

            return $this->handleServerException($serverException);
        }
    }

    /**
     * Returns required headers
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Content-Type' => self::CONTENT_TYPE,
            'api-auth-accountid' => $this->config->getAccountId(),
            'api-auth-applicationkey' => $this->config->getApplicationKey()
        ];
    }

    /**
     * @return Client
     */
    protected function getClient()
    {
        $client = new Client(
            [
                'base_uri' => $this->getBaseUrl()
            ]
        );

        return $client;
    }

    /**
     * @return string
     */
    final protected function getBaseUrl()
    {
        return 'https://inventory.dearsystems.com/ExternalApi/v2/';
    }

    /**
     * Provide endpoint's action name
     * @return string
     */
    abstract protected function getAction();

    /**
     * @param ClientException $e
     */
    protected function handleClientException(ClientException $e)
    {
        $response = $e->getResponse();
        switch ($response->getStatusCode()) {
            case 400:
                $exceptionClass = BadRequestException::class;
                break;

            case 403:
                $exceptionClass = ForbiddenRequestException::class;
                break;

            case 404:
                $exceptionClass = NotFoundException::class;
                break;

            case 405:
                $exceptionClass = MethodNotAllowedException::class;
                break;

            default:
                $exceptionClass = DearApiException::class;
                break;
        }

        $exceptionInstance = new $exceptionClass($e->getMessage());
        $exceptionInstance->setStatusCode($response->getStatusCode());

        throw $exceptionInstance;
    }

    /**
     * @param ServerException $e
     */
    protected function handleServerException(ServerException $e)
    {
        $response = $e->getResponse();
        switch ($response->getStatusCode()) {
            case 500:
                $exceptionClass = InternalServerErrorException::class;
                break;

            case 503:
                $exceptionClass = ServiceUnavailableException::class;
                break;

            default:
                $exceptionClass = DearApiException::class;
                break;
        }

        $exceptionInstance = new $exceptionClass($e->getMessage());
        $exceptionInstance->setStatusCode($response->getStatusCode());

        throw $exceptionInstance;
    }

    final public function find($guid, $parameters = [])
    {
        $parameters[$this->getGUID()] = $guid;
        return $this->execute('GET', Helper::prepareParameters($parameters));
    }

    /**
     * Represents the GUID column name
     * @var string
     */
    abstract protected function getGUID();

    final public function create($parameters = [])
    {
        if (!$this instanceof PostMethodAllowed) {
            throw new MethodNotAllowedException('Method not allowed.');
        }

        return $this->execute('POST', $parameters);
    }

    final public function update($guid, $parameters = [])
    {
        if (!$this instanceof PutMethodAllowed) {
            throw new MethodNotAllowedException('Method not allowed.');
        }

        $parameters[$this->getGUID()] = $guid;
        return $this->execute('PUT', $parameters);
    }

    final public function delete($guid, $parameters = [])
    {
        if (!$this instanceof DeleteMethodAllowed) {
            throw new MethodNotAllowedException('Method not allowed.');
        }

        $parameters[$this->deleteGUID()] = $guid;
        return $this->execute('DELETE', Helper::prepareParameters($parameters));
    }

    /**
     * GUID column name for delete action
     * @return string
     */
    protected function deleteGUID()
    {
        return 'ID';
    }
}
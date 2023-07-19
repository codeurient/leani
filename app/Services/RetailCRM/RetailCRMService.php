<?php


namespace App\Services\RetailCRM;

use Illuminate\Support\Facades\Log;
use RetailCrm\Api\Exception\Api\AccountDoesNotExistException;
use RetailCrm\Api\Exception\Api\ApiErrorException;
use RetailCrm\Api\Exception\Api\MissingCredentialsException;
use RetailCrm\Api\Exception\Api\MissingParameterException;
use RetailCrm\Api\Exception\Api\ValidationException;
use RetailCrm\Api\Exception\Client\BuilderException;
use RetailCrm\Api\Exception\Client\HandlerException;
use RetailCrm\Api\Exception\Client\HttpClientException;
use RetailCrm\Api\Factory\SimpleClientFactory;
use RetailCrm\Api\Client;
use RetailCrm\Api\Interfaces\ApiExceptionInterface;
use RetailCrm\Api\Interfaces\ClientExceptionInterface;

class RetailCRMService
{
    public Client $client;

    public function __construct()
    {
        try {

            $this->client = SimpleClientFactory::createClient(env('RETAILCRM_URL'), env('RETAILCRM_KEY'));

        } catch (BuilderException $e) {
            Log::error($e->getMessage());
        }
    }

    public function createOrder()
    {
        try {
            return $this->client->orders->list();

        } catch (AccountDoesNotExistException $e) {
            Log::error($e->getMessage());
        } catch (ApiErrorException $e) {
            Log::error($e->getMessage());
        } catch (MissingCredentialsException $e) {
            Log::error($e->getMessage());
        } catch (MissingParameterException $e) {
            Log::error($e->getMessage());
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
        } catch (HandlerException $e) {
            Log::error($e->getMessage());
        } catch (HttpClientException $e) {
            Log::error($e->getMessage());
        } catch (ApiExceptionInterface $e) {
            Log::error($e->getMessage());
        } catch (ClientExceptionInterface $e) {
            Log::error($e->getMessage());
        }
         return abort(400);
    }
}

<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use App\Logger\Logger;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

abstract class AbstractProvider
{
    /**
     * @param  string      $url
     * @param  string|bool $apiKey
     * @return false|array
     */
    public function makeRequest(string $url, string|bool $apiKey = false): false|array
    {
        $logger = new Logger();

        try {
            $client = HttpClient::create();
            if ($apiKey) {
                $client = $client->withOptions(['headers' => ['apiKey' => $apiKey]]);
            }
            $response = $client->request('GET', $url);
            if ($response->getStatusCode() == 200) {
                return $response->toArray();
            } else {
                $logger->log('Status code for' . $url . ' is ' . $response->getStatusCode());
                return false;
            }

        } catch (
            TransportExceptionInterface|ClientExceptionInterface|DecodingExceptionInterface|
        RedirectionExceptionInterface|ServerExceptionInterface $e
        ) {
            $logger->log((string)$e->getMessage());
            return false;
        }
    }

    /**
     * @return string
     */
    protected function getPathToEnv(): string
    {
        $dir = explode('/', __DIR__);
        array_splice($dir, -2);
        return implode('/', $dir) . '/.env';
    }
}

<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpClient\HttpClient;

class RateProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * @var Dotenv
     */
    private Dotenv $dotenv;
    public function __construct()
    {
        $this->dotenv = new Dotenv();
    }

    /**
     * @param  $param
     * @return false|array
     */
    public function request($param): false|array
    {
        $this->dotenv->load($this->getPathToEnv());

        $url = $_ENV['RATE_URL'];
        $apiKey = $_ENV['API_KEY'];
        return $this->makeRequest($url, $apiKey);
    }
}

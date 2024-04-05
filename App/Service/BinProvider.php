<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Dotenv\Dotenv;

class BinProvider extends AbstractProvider implements ProviderInterface
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

        $url = $_ENV['BIN_URL'] . '/' . $param;
        return $this->makeRequest($url);
    }
}

<?php

namespace App\Service;

interface ProviderInterface
{
    /**
     * @param  $param
     * @return false|array
     */
    public function request($param): false|array;
}

<?php

namespace App\Model\DataLoader;

interface DataLoaderInterface
{
    /**
     * @return mixed
     */
    public function load(): mixed;
}

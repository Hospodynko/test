<?php

namespace App\Model\Item;

interface ItemInterface
{
    /**
     * @return int
     */
    public function getBin(): int;

    /**
     * @return float
     */
    public function getAmount(): float;

    /**
     * @return string
     */
    public function getCurrency(): string;
}

<?php
declare(strict_types=1);

namespace App\Model\Item;

class Item implements ItemInterface
{
    /**
     * @var int|mixed
     */
    private int $bin;

    /**
     * @var string|mixed
     */
    private float $amount;

    /**
     * @var string|mixed
     */
    private string $currency;

    public function __construct(array $item)
    {
        $this->bin = (int)$item['bin'];
        $this->amount = (float)$item['amount'];
        $this->currency = (string)$item['currency'];
    }

    /**
     * @return int
     */
    public function getBin(): int
    {
        return $this->bin;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }
}

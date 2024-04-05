<?php
declare(strict_types=1);

namespace App\Model\Process;

use App\Model\DataLoader\DataLoader;
use App\Service\BinProvider;
use App\Model\ItemCollection\ItemCollection;
use App\Model\Item\Item;
use App\Model\ItemFactory\ItemFactory;
use App\Service\RateProvider;

class Process
{
    const COUNTRIES = ['AT','BE','BG','CY','CZ','DE','DK',
        'EE','ES','FI','FR','GR','HR','HU','IE','IT','LT',
        'LU','LV','MT','NL','PO','PT','RO','SE','SI','SK'
    ];

    /**
     * @var BinProvider
     */
    private BinProvider $binProvider;

    /**
     * @var RateProvider
     */
    private RateProvider $rateProvider;

    /**
     * @var DataLoader
     */
    private DataLoader $dataLoader;

    /**
     * @var Item
     */
    private Item $item;

    /**
     * @var ItemCollection
     */
    private ItemCollection $itemCollection;

    /**
     * @var ItemFactory
     */
    private ItemFactory $itemFactory;


    public function __construct()
    {
        $this->dataLoader = new DataLoader();
        $this->itemCollection = new ItemCollection();
        $this->binProvider = new BinProvider();
        $this->rateProvider = new RateProvider();
    }

    /**
     * @return array
     */
    public function process(): array
    {
        $collection = $this->_prepareCollection();
        $amount = [];

        if ($collection) {
            foreach ($collection as $item) {
                $bin = $this->binProvider->request($item->getBin());

                if (
                    !is_array($bin )
                    || !array_key_exists('country', $bin)
                    || !array_key_exists('alpha2', $bin['country'])
                ) {
                    continue;
                }

                $isEU = $this->isEU($bin['country']['alpha2']);

                $rate = $this->rateProvider->request(null);

                if (
                    !is_array($rate)
                    || !array_key_exists('rates', $rate)
                    || !array_key_exists($item->getCurrency(), $rate['rates'])
                ) {
                    continue;
                }

                $rate = $rate['rates'][$item->getCurrency()];

                $amntFixed = 0;

                if ($item->getCurrency() == 'EUR' || $rate == 0) {
                    $amntFixed = $item->getAmount();
                }
                if ($item->getCurrency() != 'EUR' || $rate > 0) {
                    $amntFixed = $item->getAmount() / $rate;
                }
                $amount[] =  round($amntFixed * ($isEU ? 0.01 : 0.02), 2, PHP_ROUND_HALF_UP);
            }
        }
        return $amount;
    }

    /**
     * @param  string $flag
     * @return bool
     */
    private function isEU(string $flag): bool
    {
        return in_array($flag, self::COUNTRIES);
    }

    /**
     * @return array
     */
    private function _prepareCollection(): array
    {
        $collection = [];
        foreach ($this->dataLoader->load() as $item) {
            $collection = $this->itemCollection->getCollection($item);
        }
        return $collection;
    }
}

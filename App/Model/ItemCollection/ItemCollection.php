<?php
declare(strict_types=1);

namespace App\Model\ItemCollection;

use App\Model\Item\Item;

class ItemCollection implements ItemCollectionInterface
{
    /**
     * @var array
     */
    private array $itemCollection;

    /**
     * @param  array $item
     * @return void
     */
    public function add(array $item): void
    {
        $this->itemCollection[] = new Item($item);
    }

    /**
     * @param  array $item
     * @return array
     */
    public function getCollection(array $item): array
    {
        $this->add($item);
        return $this->itemCollection;
    }
}

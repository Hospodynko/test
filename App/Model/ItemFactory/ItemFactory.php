<?php
declare(strict_types=1);

namespace App\Model\ItemFactory;

use App\Model\Item\Item;

class ItemFactory implements ItemFactoryInterface
{
    public static function create($item): Item
    {
        return new Item($item);
    }
}

<?php

namespace App\Model\ItemFactory;

use App\Model\Item\Item;

interface ItemFactoryInterface
{
    public static function create($item): Item;
}

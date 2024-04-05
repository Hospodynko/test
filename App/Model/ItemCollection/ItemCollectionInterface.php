<?php

namespace App\Model\ItemCollection;

interface ItemCollectionInterface
{
    public function getCollection(array $item): array;
}

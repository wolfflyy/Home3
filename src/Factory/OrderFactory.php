<?php

namespace App\Factory;

use App\Entity\OrderSession;
use App\Entity\OrderItem;
use App\Entity\Manga;


/**
 * Class OrderFactory.
 */
class OrderFactory
{
    /**
     * Creates an order.
     */
    public function create(): OrderSession
    {
        $orderSession = new OrderSession();
        $orderSession
            ->setStatus(OrderSession::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $orderSession;
    }

    /**
     * Creates an item for a product.
     */
    public function createItem(Manga $manga): OrderItem
    {
        $item = new OrderItem();
        $item->setManga($manga);
        $item->setQuantity(1);

        return $item;
    }
}

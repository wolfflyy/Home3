<?php

namespace App\Factory;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Manga;

class OrderFactory
{
    /**
     * Creates an order.
     *
     * @return Order
     */
    public function create(): Order
    {
        $order = new Order();
        $order
            ->setStatus(Order::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $order;
    }
    /**
     * Creates an item for manga.
     *
     * @param Manga $manga
     *
     * @return OrderItem
     */

    public function createItem(Manga $manga): OrderItem
    {
        $item = new OrderItem();
        $item->setManga($manga);
        $item->setQuantity(1);

        return $item;
    }
}

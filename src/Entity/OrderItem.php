<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank()]
    #[Assert\GreaterThanOrEqual(1)]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: OrderSession::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private $orderRef;

    #[ORM\ManyToOne(targetEntity: Manga::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $mangas;

    /**
     * Tests if the given item given corresponds to the same order item.
     */
    public function equals(OrderItem $item): bool
    {
        return $this->getMangas()->getId() === $item->getMangas()->getId();
    }

    /**
     * Calculates the item total.
     *
     * @return float|int
     */
    public function getTotal(): float
    {
        return $this->getMangas()->getPrice() * $this->getQuantity();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getOrderRef(): ?OrderSession
    {
        return $this->orderRef;
    }

    public function setOrderRef(?OrderSession $orderRef): self
    {
        $this->orderRef = $orderRef;

        return $this;
    }

    public function getMangas(): ?Manga
    {
        return $this->mangas;
    }

    public function setManga(?Manga $manga): self
    {
        $this->mangas = $manga;

        return $this;
    }
}

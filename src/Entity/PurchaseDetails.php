<?php

namespace App\Entity;

use App\Repository\PurchaseDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseDetailsRepository::class)]
class PurchaseDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Amount;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Status;

    #[ORM\ManyToMany(targetEntity: Manga::class, mappedBy: 'purchase')]
    private $mangas;

    public function __construct()
    {
        $this->mangas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->Amount;
    }

    public function setAmount(?int $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(?string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    /**
     * @return Collection<int, Manga>
     */
    public function getMangas(): Collection
    {
        return $this->mangas;
    }

    public function addManga(Manga $manga): self
    {
        if (!$this->mangas->contains($manga)) {
            $this->mangas[] = $manga;
            $manga->addPurchase($this);
        }

        return $this;
    }

    public function removeManga(Manga $manga): self
    {
        if ($this->mangas->removeElement($manga)) {
            $manga->removePurchase($this);
        }

        return $this;
    }
}

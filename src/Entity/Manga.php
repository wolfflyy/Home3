<?php

namespace App\Entity;

use App\Repository\MangaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MangaRepository::class)]
class Manga
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Image;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Price;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'orderItems')]
    private $orderItems;

    #[ORM\ManyToOne(targetEntity: Genre::class, inversedBy: 'mangas')]
    #[ORM\JoinColumn(nullable: false)]
    private $Genre;

    #[ORM\ManyToOne(targetEntity: Artist::class, inversedBy: 'mangas')]
    #[ORM\JoinColumn(nullable: false)]
    private $Artist;

    #[ORM\Column(type: 'date')]
    private $create_date;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

//    public function getImagePath()
//    {
//        return 'public/uploads/manga_image'.$this->getImage();
//    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(?string $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        $this->orderItems->removeElement($orderItem);

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->Genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->Genre = $genre;

        return $this;
    }

//    public function addGenre(Genre $genre): self
//    {
//        if (!$this->Genre->contains($genre)) {
//            $this->Genre[] = $genre;
//        }
//
//        return $this;
//    }
//
//    public function removeGenre(Genre $genre): self
//    {
//        $this->Genre->removeElement($genre);
//
//        return $this;
//    }



    public function getArtist(): ?Artist
    {
        return $this->Artist;
    }

    public function setArtist(?Artist $Artist): self
    {
        $this->Artist = $Artist;

        return $this;
    }
//    public function addArtist(Artist $artist): self
//    {
//        if (!$this->Artist->contains($artist)) {
//            $this->Artist[] = $artist;
//        }
//
//        return $this;
//    }
//
//    public function removeArtist(Artist $artist): self
//    {
//        $this->Artist->removeElement($artist);
//
//        return $this;
//    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->create_date;
    }

    public function setCreateDate(\DateTimeInterface $create_date): self
    {
        $this->create_date = $create_date;

        return $this;
    }
}

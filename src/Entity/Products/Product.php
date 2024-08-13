<?php

namespace App\Entity\Products;

use App\Entity\Comments\Comment;
use App\Repository\Products\ProductRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $name;
    #[ORM\Column]
    private int $quantity;
    #[ORM\Column]
    private int $soldQuantity;

    #[ORM\Column(length: 2000)]
    private string $description;

    #[ORM\Column(length: 2000)]
    private string $productUseGuide;

    #[ORM\Column(length: 500)]
    private string $imageUrl;

    #[ORM\Column(length: 500)]
    private string $discountPercent;
    #[ORM\Column]
    private float $price;
    #[ORM\Column(type: "datetime")]
    private DateTime $createdAt;

    #[ORM\Column(type: "datetime")]
    private DateTime $updatedAt;
    #[ORM\Column(length: 100)]
    private string $categoryId;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $comments;

    public function __construct(
        string $name,
        int    $quantity,
        float  $price,
        string $description,
        string $productUseGuide,
        string $imageUrl,
        string $discountPercent,
        string $categoryId
    )
    {
        $this->id = Uuid::v4()->toString();
        $this->name = $name;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imageUrl = $imageUrl;
        $this->discountPercent = $discountPercent;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->categoryId = $categoryId;
        $this->price = $price;
        $this->soldQuantity = 0;
        $this->comments = new ArrayCollection();
    }

    public static function create(
        string $name,
        int    $quantity,
        float  $price,
        string $description,
        string $productUseGuide,
        string $imageUrl,
        string $discountPercent,
        string $categoryId,
    ): self
    {
        return new Product(
            $name,
            $quantity,
            $price,
            $description,
            $productUseGuide,
            $imageUrl,
            $discountPercent,
            $categoryId,
        );
    }

    public function update(
        string $name,
        int    $quantity,
        string $description,
        string $productUseGuide,
        string $discountPercent,
        float  $price
    ): Product
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->discountPercent = $discountPercent;
        $this->updatedAt = new DateTime();
        $this->price = $price;
        return $this;
    }

    public function getDiscountedPrice(): float
    {
        return $this->discountPercent == 0 ? $this->price : $this->price - $this->price * $this->discountPercent / 100;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getProductUseGuide(): string
    {
        return $this->productUseGuide;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getDiscountPercent(): string
    {
        return $this->discountPercent;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setProductUseGuide(string $productUseGuide): self
    {
        $this->productUseGuide = $productUseGuide;
        return $this;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function setDiscountPercent(string $discountPercent): self
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }


    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): Product
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getSoldQuantity(): int
    {
        return $this->soldQuantity;
    }

    public function setSoldQuantity(int $soldQuantity): Product
    {
        $this->soldQuantity = $soldQuantity;
        return $this;
    }

    public function getInStock(): int
    {
        return $this->quantity - $this->soldQuantity;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function setComments(Collection $comments): void
    {
        $this->comments = $comments;
    }

}



<?php

namespace App\Entity\Products;

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

    #[ORM\Column(length: 2000)]
    private string $description;

    #[ORM\Column(length: 2000)]
    private string $productUseGuide;

    #[ORM\Column(length: 500)]
    private string $imageUrl;

    #[ORM\Column(length: 500)]
    private string $discountPercent;

    #[ORM\Column(type: "datetime")]
    private DateTime $createdAt;

    #[ORM\Column(type: "datetime")]
    private DateTime $updatedAt;
    #[ORM\Column(length: 100)]
    private string $categoryId;


    #[
        ORM\OneToMany(
            targetEntity: ProductVariant::class,
            mappedBy: "product",
            cascade: ["persist", "remove"]
        )
    ]
    private Collection $productVariants;

    public function __construct(
        string $name,
        string $description,
        string $productUseGuide,
        string $imageUrl,
        string $discountPercent,
        string $categoryId
    )
    {
        $this->id = Uuid::v4()->toString();
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imageUrl = $imageUrl;
        $this->discountPercent = $discountPercent;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->categoryId = $categoryId;
        $this->productVariants = new ArrayCollection();
    }

    public static function create(
        string $name,
        string $description,
        string $productUseGuide,
        string $imageUrl,
        string $discountPercent,
        string $categoryId
    ): self
    {
        return new Product(
            $name,
            $description,
            $productUseGuide,
            $imageUrl,
            $discountPercent,
            $categoryId
        );
    }

    public function update(
        string $name,
        string $description,
        string $productUseGuide,
        string $discountPercent
    ): Product
    {
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->discountPercent = $discountPercent;
        $this->updatedAt = new DateTime();

        return $this;
    }


    /**
     * @param array<int,mixed> $updateVariants
     */

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

    public function getProductVariants(): Collection
    {
        return $this->productVariants;
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

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}



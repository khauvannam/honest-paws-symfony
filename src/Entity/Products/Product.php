<?php

namespace App\Entity\Products;

use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;  
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 2000)]
    private ?string $description = null;

    #[ORM\Column(length: 2000)]
    private ?string $productUseGuide = null;

    #[ORM\Column(length: 500)]
    private ?string $imageUrl = null;

    #[ORM\Column(length: 500)]
    private ?string $discountPercent = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updatedAt;

    #[ORM\OneToMany(targetEntity: ProductVariant::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $productVariants;

    public function __construct(string $name, string $description, string $productUseGuide, string $imageUrl, string $discountPercent, DateTime $createdAt, DateTime $updateAt)
    {
        $this->id = Uuid::v4();
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imageUrl = $imageUrl;
        $this->discountPercent = $discountPercent;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->productVariants = new ArrayCollection();
    }

    public static function Create(string $name, string $description, string $productUseGuide, string $imageUrl, string $discountPercent, DateTime $createdAt, DateTime $updateAt): Product
    {
        return new Product($name, $description, $productUseGuide, $imageUrl, $discountPercent, $createdAt, $updateAt);
    }

    public function Update(string $name, string $description, string $productUseGuide, string $imageUrl, string $discountPercent, DateTime $createdAt, DateTime $updateAt): Product {
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imageUrl = $imageUrl;
        $this->discountPercent = $discountPercent;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updateAt;

        return $this;
    }

    public function addProductVariant(ProductVariant $productVariant): void
    {
        if (!$this->productVariants->contains($productVariant)) {
            $this->productVariants[] = $productVariant;
            $productVariant->setProduct($this);
        }
    }

    public function updateVariantList(array $updateVariants): void
    {
        $this->productVariants->clear();
        foreach ($updateVariants as $variant) {
            $this->addProductVariant($variant);
        }
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getProductUseGuide(): ?string
    {
        return $this->productUseGuide;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getDiscountPercent(): ?string
    {
        return $this->discountPercent;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }
    public function getProductVariants(): Collection
    {
        return $this->productVariants;
    }
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setProductUseGuide(?string $productUseGuide): self
    {
        $this->productUseGuide = $productUseGuide;
        return $this;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function setDiscountPercent(?string $discountPercent): self
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }

    public function setCreatedAt(?DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt(?DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}

?>

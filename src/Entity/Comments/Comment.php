<?php

namespace App\Entity\Comments;

use App\Entity\Products\Product;
use App\Entity\Users\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class Comment
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;
    #[ORM\Column]
    private string $content;
    #[ORM\Column(type: "string", length: 36)]
    private string $userId;

    #[ORM\Column(type: "string", length: 36)]
    private string $productId;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id")]
    private ?Product $product = null;
    private DateTime $createdAt;

    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->id = Uuid::v4()->toString();
        $this->content = $content;
        $this->createdAt = new DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Comment
    {
        $this->id = $id;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Comment
    {
        $this->content = $content;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Comment
    {
        $this->user = $user;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): Comment
    {
        $this->product = $product;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Comment
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): Comment
    {
        $this->userId = $userId;
        return $this;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): Comment
    {
        $this->productId = $productId;
        return $this;
    }
   
}
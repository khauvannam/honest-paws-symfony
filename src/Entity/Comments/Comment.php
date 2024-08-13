<?php

namespace App\Entity\Comments;

use App\Entity\Products\Product;
use App\Entity\Users\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Comment
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;
    #[ORM\Column]
    private string $content;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    private User $user;
    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'comments')]
    private Product $product;
    private DateTime $createdAt;

    /**
     * @param string $id
     * @param string $content
     * @param User $user
     * @param Product $product
     * @param DateTime $createdAt
     */
    public function __construct(string $id, string $content, User $user, Product $product, DateTime $createdAt)
    {
        $this->id = $id;
        $this->content = $content;
        $this->user = $user;
        $this->product = $product;
        $this->createdAt = $createdAt;
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
}
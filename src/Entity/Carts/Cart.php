<?php

namespace App\Entity\Carts;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class Cart
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(length: 255)]
    private ?string $CustomerId;
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: "cart")]
    private Collection $cartItems;

    #[ORM\Column(type: 'datetime')]
    private DateTime $UpdateDate;
    private CartStatus $cartStatus;

    private function __construct(?string $CustomerId)
    {
        $this->id = Uuid::v4()->toString();
        $this->CustomerId = $CustomerId;
        $this->UpdateDate = new DateTime();
        $this->cartItems = new ArrayCollection();
        $this->cartStatus = CartStatus::preparing;
    }

    public function getCartStatus(): CartStatus
    {
        return $this->cartStatus;
    }

    public function setCartStatus(CartStatus $cartStatus): Cart
    {
        $this->cartStatus = $cartStatus;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCustomerId(): string
    {
        return $this->CustomerId;
    }

    public function getCartItemsList(): Collection
    {
        return $this->cartItems;
    }

    public function getUpdateDate(): DateTime
    {
        return $this->UpdateDate;
    }

    public static function create(string $customerId): self
    {
        return new self($customerId);
    }

    public function AddCartItem(CartItem $newCartItem): self
    {
        foreach ($this->cartItems as $cartItem) {
            if ($cartItem->getProductId() === $newCartItem->getProductId()) {
                $newQuantity = $cartItem->getQuantity() + $newCartItem->getQuantity();
                $cartItem->setQuantity($newQuantity);
            }
            $this->cartItems[] = $cartItem;
            $cartItem->setCart($this);
        }
        return $this;
    }

    public function removeCartItem(CartItem $cartItem): self
    {
        if ($this->cartItems->contains($cartItem)) {
            $this->cartItems->removeElement($cartItem);
        }
        return $this;
    }
}

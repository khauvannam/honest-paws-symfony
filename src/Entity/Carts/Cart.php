<?php

namespace App\Entity\Carts;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Carts\CartRepository;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $CustomerId;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartItem::class, cascade: ['persist', 'remove'])]
    private Collection $CartItemsList;

    #[ORM\Column(type: 'datetime')]
    private DateTime $UpdateDate;

    private function __construct(string $CustomerId)
    {
        $this->CustomerId = $CustomerId;
        $this->UpdateDate = new DateTime();
        $this->CartItemsList = new ArrayCollection();
    }

    public static function Create(string $CustomerId): self
    {
        return new self($CustomerId);
    }

    public function Update(string $CustomerId): self
    {
        $this->CustomerId = $CustomerId;
        $this->UpdateDate = new DateTime();
        return $this;
    }

    public function RemoveAllCartItemNotExist(array $cartItemRequests): void
    {
        $cartItemIds = array_map(fn ($request) => $request->getCartItemId(), $cartItemRequests);
        foreach ($this->CartItemsList as $key => $cartItem) {
            if (!in_array($cartItem->getCartItemId(), $cartItemIds)) {
                $this->CartItemsList->removeElement($cartItem);
            }
        }
    }

    public function addCartItem(CartItem $cartItem): void
    {
        if (!$this->CartItemsList->contains($cartItem)) {
            $this->CartItemsList[] = $cartItem;
            $cartItem->setCart($this);
        }
    }

    public function removeCartItem(CartItem $cartItem): void
    {
        if ($this->CartItemsList->removeElement($cartItem)) {
            if ($cartItem->getCart() === $this) {
                $cartItem->setCart(null);
            }
        }
    }

    public function getCustomerId(): string
    {
        return $this->CustomerId;
    }

    public function setCustomerId(string $CustomerId): void
    {
        $this->CustomerId = $CustomerId;
    }
}

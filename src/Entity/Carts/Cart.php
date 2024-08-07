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
<<<<<<< HEAD
=======

>>>>>>> origin/namdeptrai
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $CustomerId;

<<<<<<< HEAD
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: "cart", cascade: ["persist", "remove"])]
=======
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: "cart")]
>>>>>>> origin/namdeptrai
    private Collection $CartItemsList;

    #[ORM\Column(type: 'datetime')]
    private DateTime $UpdateDate;
<<<<<<< HEAD

    public function __construct(string $CustomerId)
=======
    private CartStatus $cartStatus;

    private function __construct(string $CustomerId)
>>>>>>> origin/namdeptrai
    {
        $this->id = Uuid::v4()->toString();
        $this->CustomerId = $CustomerId;
        $this->UpdateDate = new DateTime();
        $this->CartItemsList = new ArrayCollection();
<<<<<<< HEAD
=======
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
        return $this->CartItemsList;
    }

    public function getUpdateDate(): DateTime
    {
        return $this->UpdateDate;
>>>>>>> origin/namdeptrai
    }

    public static function create(string $customerId): self
    {
        return new self($customerId);
    }

    public function addItem(string $productId, string $name, int $quantity, float $price, string $imageUrl, string $description): void
    {
        foreach ($this->CartItemsList as $item) {
            if ($item->getProductId() === $productId) {
                $item->update($name, $quantity, $price, $imageUrl, $description);
                return;
            }
        }

        $item = CartItem::create($productId, $name, $quantity, $price, $imageUrl, $description);
        $item->setCart($this);
        $this->CartItemsList->add($item);
    }


    public function Update(CartItemRequest $cartItemRequest): void
    {
        $existingItem = $this->CartItemsList->filter(function (CartItem $item) use ($cartItemRequest) {
            return $item->getId() === $cartItemRequest->getCartItemId();
        })->first();

        if ($existingItem !== false) {
            // Update the existing cart item
            $existingItem->setPrice($cartItemRequest->getPrice());
            $existingItem->changeQuantity($cartItemRequest->getQuantity());
        } else {
            // Create and add a new cart item
            $newItem = CartItem::create(
                $cartItemRequest->getProductId(),
                $cartItemRequest->getVariantId(),
                $cartItemRequest->getName(),
                $cartItemRequest->getQuantity(),
                $cartItemRequest->getPrice(),
                $cartItemRequest->getImageUrl(),
                $cartItemRequest->getDescription()
            );

            $this->CartItemsList->add($newItem);
        }

        $this->UpdateDate = new DateTime(); // Update the cart update date
    }

    public function RemoveAllCartItemNotExist(array $cartItemRequests): void
    {
        $cartItemIds = array_map(fn($request) => $request->getCartItemId(), $cartItemRequests);
        foreach ($this->CartItemsList as $cartItem) {
            if (!in_array($cartItem->getCartItemId(), $cartItemIds)) {
                $this->CartItemsList->removeElement($cartItem);
            }
        }
    }

    public function removeAllCartItem(): void
    {
        $this->CartItemsList->clear();
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
        return $this->CartItemsList;
    }

    public function getUpdateDate(): DateTime
    {
        return $this->UpdateDate;
    }

}

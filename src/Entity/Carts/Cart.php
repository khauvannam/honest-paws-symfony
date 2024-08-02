<?php

namespace App\Entity\Carts;


use App\Repository\Carts\CartRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
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

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $CustomerId;

    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: "cart")]
    private Collection $CartItemsList;

    #[ORM\Column(type: 'datetime')]
    private DateTime $UpdateDate;

    private function __construct(string $CustomerId)
    {
        $this->id = Uuid::v4()->toString();
        $this->CustomerId = $CustomerId;
        $this->UpdateDate = new DateTime();
        $this->CartItemsList = new ArrayCollection();
    }

    public static function Create(string $CustomerId): self
    {
        return new self($CustomerId);
    }

    public function Update(CartItemRequest $cartItemRequest): void
    {
// Find the existing cart item
        $existingItem = $this->CartItemsList->filter(function (CartItem $item) use ($cartItemRequest) {
            return $item->getCartItemId() === $cartItemRequest->getCartItemId();
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
        $cartItemIds = array_map(fn ($request) => $request->getCartItemId(), $cartItemRequests);
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
    
}

<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CartRepository;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CustomerId = null;

    #[ORM\Column(length: 255)]
    private ?string $CartId = null;

    #[ORM\OneToMany(length: 255)]
    private Collection $CartItemsList;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $UpdateDate = null;

    private function __construct(string $CustomerId, string $CartId, DateTime $UpdateDate)
    {
        $this->CustomerId = $CustomerId;
        $this->CartId = $CartId;
        $this->UpdateDate = $UpdateDate;
        $this->CartItemsList = new ArrayCollection();
    }

    public static function Create(string $CustomerId, string $CartId, DateTime $UpdateDate): self
    {
        return new self($CustomerId, $CartId, $UpdateDate);
    }

    public function Update(string $CustomerId, string $CartId, DateTime $UpdateDate): self
    {
        $this->CustomerId = $CustomerId;
        $this->CartId = $CartId;
        $this->UpdateDate = $UpdateDate;
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): ?string
    {
        return $this->CustomerId;
    }

    public function getCartId(): ?string
    {
        return $this->CartId;
    }

    public function getUpdateDate(): ?DateTime
    {
        return $this->UpdateDate;
    }

    public function getCartItemsList(): Collection
    {
        return $this->CartItemsList;
    }
}

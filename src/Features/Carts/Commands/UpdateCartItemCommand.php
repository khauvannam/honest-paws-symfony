<?php

namespace App\Features\Carts;

use App\Entity\Carts\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateCartItemCommand
{
    private ?int $cartItemId;
    private string $productId;
    private string $variantId;
    private string $name;
    private int $quantity;
    private float $price;
    private string $imageUrl;
    private string $description;

    public function __construct(
        ?int $cartItemId,
        string $productId,
        string $variantId,
        string $name,
        int $quantity,
        float $price,
        string $imageUrl,
        string $description
    ) {
        $this->cartItemId = $cartItemId;
        $this->productId = $productId;
        $this->variantId = $variantId;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->description = $description;
    }

    public function getCartItemId(): ?int
    {
        return $this->cartItemId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getVariantId(): string
    {
        return $this->variantId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

class UpdateCartItemHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateCartItemCommand $command)
    {
        $cartItemId = $command->getCartItemId();
        $cartItem = null;

        if ($cartItemId) {
            $cartItem = $this->entityManager->getRepository(CartItem::class)->find($cartItemId);
            if (!$cartItem) {
                throw new \Exception('CartItem not found');
            }
        }

        if (!$cartItem) {
            $cartItem = new CartItem(
                $command->getProductId(),
                $command->getVariantId(),
                $command->getName(),
                $command->getQuantity(),
                $command->getPrice(),
                $command->getImageUrl(),
                $command->getDescription()
            );
        } else {
            $cartItem->setProductId($command->getProductId());
            $cartItem->setVariantId($command->getVariantId());
            $cartItem->setName($command->getName());
            $cartItem->setQuantity($command->getQuantity());
            $cartItem->setPrice($command->getPrice());
            $cartItem->setImageUrl($command->getImageUrl());
            $cartItem->setDescription($command->getDescription());
        }

        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();
    }
}

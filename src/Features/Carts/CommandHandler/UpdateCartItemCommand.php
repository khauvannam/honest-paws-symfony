<?php

namespace App\Features\Carts\Handlers;

use App\Repository\Carts\CartItemRepository;
use App\Features\Carts\UpdateCartItemCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateCartItemHandler
{

    private cartItemRepository $cartItemRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(UpdateCartItemCommand $command, CartItemRepository $cartItemRepository)
    {
        $cartItem = $this->cartItemRepository->findById;


        if ($cartItem) {
            $cartItem = $this->cartItemRepository->findById;
            if (!$cartItem) {
                throw new \Exception('CartItem not found');
            }
        }

        if (!$cartItem) {
            $cartItem = new cartItem(
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
    }
}

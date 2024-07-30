<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\CartItem;
use App\Features\Carts\UpdateCartItemCommand;
use App\Repository\Carts\CartItemRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCartItemCommandHandler
{

    public function __construct(private CartItemRepository $cartItemRepository)
    {
    }

    public function __invoke(UpdateCartItemCommand $command)
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

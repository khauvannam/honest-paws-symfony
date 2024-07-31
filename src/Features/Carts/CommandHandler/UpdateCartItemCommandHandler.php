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

    /**
     * @throws \Exception
     */
    public function __invoke(UpdateCartItemCommand $command): void
    {
        global $cartItem;
        $cartItem = $this->cartItemRepository->findById($command->getCartItemId());

        if (!$cartItem) {
            $cartItem = CartItem::create(
                $command->getProductId(),
                $command->getVariantId(),
                $command->getName(),
                $command->getQuantity(),
                $command->getPrice(),
                $command->getImageUrl(),
                $command->getDescription()
            );
        } else {
            $cartItem->update($command->getName(), $command->getQuantity(), $command->getPrice(), $command->getImageUrl(), $command->getDescription());
        }
        $this->cartItemRepository->update($cartItem);

    }
}

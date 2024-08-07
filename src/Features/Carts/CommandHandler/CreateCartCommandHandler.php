<?php 
namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\CartItem;
use App\Entity\Carts\Cart;
use App\Features\Carts\Command\CreateCartCommand;
use App\Repository\Carts\CartItemRepository;
use App\Repository\Carts\CartRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
#[AsMessageHandler]
class CreateCartCommandHandler
{
    private CartItemRepository $cartItemRepository;
    private CartRepository $cartRepository;

    public function __construct(CartItemRepository $cartItemRepository, CartRepository $cartRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
        $this->cartRepository = $cartRepository;
    }

     public function __invoke(CreateCartCommand $command): void
        {
            $cartItem = CartItem::create(
                $command->getProductId(),
                $command->getName(),
                $command->getQuantity(),
                $command->getPrice(),
                $command->getImageUrl(),
                $command->getDescription()
            );
            $cart = new Cart('49cc70b3-34cb-4153-8f04-827330bc6bb9');
            $cartItem->setCart($cart);

            $this->cartItemRepository->save($cartItem); 
            $this->cartRepository->save($cart);
        }
}

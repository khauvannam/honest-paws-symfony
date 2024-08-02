<?php

namespace App\Features\Carts\CommandHandler;


use App\Entity\Carts\Cart;
use App\Features\Carts\Command\CreateCartCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Carts\CartRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class CreateCartCommandHandler implements CommandHandlerInterface
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function __invoke(CreateCartCommand $command, Cart $cart): void
    {
        $cart = Cart::Create($command->getCustomerId());

        $this->cartRepository->save($cart);
    }
}

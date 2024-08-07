<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\Cart;
use App\Entity\Product;
use App\Features\Carts\Command\CreateCartCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Carts\CartRepository;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateCartCommandHandler implements CommandHandlerInterface
{
    private CartRepository $cartRepository;
    private ProductRepository $productRepository;

    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(CreateCartCommand $command): void
    {
        $cart = $this->cartRepository->findByCustomerId($command->getCustomerId());

        if (!$cart) {
            $cart = Cart::create($command->getCustomerId());
        }

        $product = $this->productRepository->findById($command->getProductId());

        if (!$product) {
            throw new \Exception('Product not found.');
        }

        $cart->addItem($product, $command->getQuantity());

        $this->cartRepository->save($cart);
    }
}

<?php

namespace App\Subscribers;

use App\Events\PlaceOrderEvent;
use App\Repository\Products\ProductRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PlaceOrderSubscriber implements EventSubscriberInterface
{

    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [PlaceOrderEvent::class => 'onPlaceOrder'];
    }

    public function onPlaceOrder(PlaceOrderEvent $event): void
    {
        $productQuantities = $event->getProductQuantity();

        foreach ($productQuantities as $productId => $quantity) {
            $this->decreaseProductQuantity($productId, $quantity);
        }
    }

    private function decreaseProductQuantity(string $productId, int $quantity): void
    {
        $product = $this->productRepository->findOneBy(['id' => $productId]);
        if ($product && $product->getQuantity() >= $quantity) {
            $product->setSoldQuantity($product->getSoldQuantity() + $quantity);
            $product->setQuantity($product->getQuantity() - $quantity);
        }
        $this->productRepository->update($product);
    }
}
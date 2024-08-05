<?php

namespace App\Entity\Orders;

use App\Repository\Orders\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order
{
    public function __construct(string $userId, string $shippingAddress, int $orderStatus = 0) // OrderStatus::PENDING
    {
        $this->id = Uuid::v4()->toString();
        $this->userId = $userId;
        $this->shippingAddress = $shippingAddress;
        $this->orderStatus = $orderStatus;
        $this->orderDate = new \DateTime();
        $this->orderLines = new ArrayCollection();
        $this->orderTotal = 0.0;
    }


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"string", length:36)]

    private string $id ;


    #[ORM\Column(type:"string", length:255)]
    

    private string $userId;


    #[ORM\Column(type:"datetime")]

    private \DateTime $orderDate;


    #[ORM\Column(type:"decimal", scale:2)]

    private float $orderTotal;


    #[ORM\Column(type:"integer")]

    private int $orderStatus;


    #[ORM\Column(type:"string", length:255)]
    

    private string $shippingMethodId;


    #[ORM\Column(type:"string", length:500)]
    

    private string $shippingAddress;


    #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $orderLines;

    public static function create(
        string $userId,
        string $shippingAddress,
        int $orderStatus = 0 // OrderStatus::PENDING
    ): self {
        return new self($userId, $shippingAddress, $orderStatus);
    }

    public function addOrderLine(OrderLine $orderLine): void
    {
        $this->orderLines->add($orderLine);
        $this->orderTotal += $orderLine->getPrice();
    }

    public function updateOrderStatus(int $orderStatus): void
    {
        $this->orderStatus = $orderStatus;
    }

    // Getters and setters...
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getOrderDate(): \DateTime
    {
        return $this->orderDate;
    }

    public function getOrderTotal(): float
    {
        return $this->orderTotal;
    }

    public function getOrderStatus(): int
    {
        return $this->orderStatus;
    }

    public function getShippingMethodId(): string
    {
        return $this->shippingMethodId;
    }

    public function getShippingAddress(): string
    {
        return $this->shippingAddress;
    }

    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    public function setOrderDate(\DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    public function setOrderTotal(float $orderTotal): void
    {
        $this->orderTotal = $orderTotal;
    }

    public function setOrderStatus(int $orderStatus): void
    {
        $this->orderStatus = $orderStatus;
    }

    public function setShippingMethodId(string $shippingMethodId): void
    {
        $this->shippingMethodId = $shippingMethodId;
    }

    public function setShippingAddress(string $shippingAddress): void
    {
        $this->shippingAddress = $shippingAddress;
    }
}

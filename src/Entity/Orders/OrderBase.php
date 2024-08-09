<?php

namespace App\Entity\Orders;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class OrderBase
{
    public function __construct(string $customerId, string $shippingAddress, string $shippingMethodId = '123', OrderStatus $orderStatus = OrderStatus::pending) // OrderStatus::PENDING
    {
        $this->id = Uuid::v4()->toString();
        $this->customerId = $customerId;
        $this->shippingAddress = $shippingAddress;
        $this->orderStatus = $orderStatus;
        $this->shippingMethodId = $shippingMethodId;
        $this->orderDate = new \DateTime();
        $this->orderLines = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\Column(type: "string")]
    private string $id;


    #[ORM\Column(type: "string", length: 255)]
    private string $customerId;


    #[ORM\Column(type: "datetime")]
    private \DateTime $orderDate;


    #[ORM\Column(type: "decimal", scale: 2)]
    private float $orderTotal = 0;


    #[ORM\Column]
    private OrderStatus $orderStatus;


    #[ORM\Column(type: "string", length: 255)]
    private string $shippingMethodId;


    #[ORM\Column(type: "string", length: 500)]
    private string $shippingAddress;


    #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $orderLines;

    public static function create(
        string $customerId,
        string $shippingAddress,
    ): self
    {
        return new self($customerId, $shippingAddress);
    }

    public function addOrderLine(OrderLine $orderLine): void
    {
        $this->orderLines->add($orderLine);
        $this->orderTotal += $orderLine->getTotal();
        $orderLine->setOrder($this);
    }

    public function updateOrderStatus(OrderStatus $orderStatus): void
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
        return $this->customerId;
    }

    public function getOrderDate(): \DateTime
    {
        return $this->orderDate;
    }

    public function getOrderTotal(): float
    {
        return $this->orderTotal;
    }

    public function getOrderStatus(): OrderStatus
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

    public function setUserId(string $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function setOrderDate(\DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    public function setOrderTotal(float $orderTotal): void
    {
        $this->orderTotal = $orderTotal;
    }

    public function setOrderStatus(OrderStatus $orderStatus): void
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

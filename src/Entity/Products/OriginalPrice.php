<?php
namespace App\Entity\Products;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

class OriginalPrice
{
    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private float $value;

    #[ORM\Column(type: "string", length: 3)]
    private string $currency;

    private function __construct()
    {
    }

    public static function create(float $value, string $currency = "USD"): self
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("Price value must be positive");
        }

        $price = new self();
        $price->value = $value;
        $price->currency = $currency;

        return $price;
    }

    public function update(float $value, string $currency = "USD"): void
    {
        if ($value <= 0) {
            throw new InvalidArgumentException("Price value must be positive");
        }

        $this->value = $value;
        $this->currency = $currency;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
?>
?>
 ?>
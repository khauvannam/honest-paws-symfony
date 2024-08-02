<?php

namespace App\Entity\Categories;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
<<<<<<< HEAD

=======
>>>>>>> origin/tranthang
class Category
{
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private string $id;
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;
    #[ORM\Column(type: 'string', length: 255)]
    private string $description;

    /**
     * @param string $name
     * @param string $description
     */
    public function __construct(string $name, string $description)
    {
        $this->id = Uuid::v4()->toString();
        $this->name = $name;
        $this->description = $description;
    }

    public static function create(string $name, string $description): Category
    {
        return new self($name, $description);
    }

    public function update(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;
    }
}

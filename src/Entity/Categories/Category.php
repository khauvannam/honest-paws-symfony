<?php

namespace App\Entity\Categories;

use App\Repository\Categories\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{


    #[ORM\Id]
    #[ORM\Column]
    private string $id;
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;
    #[ORM\Column(type: 'string', length: 255)]
    private string $description;
    #[ORM\Column(type: 'string', length: 100)]
    private string $imgUrl;

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

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

    public function __construct(string $name, string $description, string $imgUrl)
    {
        $this->id = Uuid::v4()->toString();
        $this->name = $name;
        $this->description = $description;
        $this->imgUrl = $imgUrl;
    }

    public static function create(string $name, string $description, string $imgUrl): Category
    {
        return new self($name, $description, $imgUrl);
    }

    public function update(string $name, string $description, string $imgUrl): void
    {
        $this->name = $name;
        $this->description = $description;
        $this->imgUrl = $imgUrl;
    }
    public function setImageUrl(string $imageUrl): self
    {
        $this->imgUrl = $imageUrl;
        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\CategorysRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorysRepository::class)]
#[ORM\Table(name: "categorys")]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private ?int $tmdb_category_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct(int $tmdb_category_id, string $name)
    {
        $this->tmdb_category_id = $tmdb_category_id;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTmdbCategoryId(): ?int
    {
        return $this->tmdb_category_id;
    }

    public function setTmdbCategoryId(int $tmdb_category_id): static
    {
        $this->tmdb_category_id = $tmdb_category_id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\SeriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeriesRepository::class)]
#[ORM\Table(name: "series")]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(nullable: true)]
    public ?float $imbd_score = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $synopsis = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $categorys = null;

    #[ORM\Column(length: 255, nullable: true)]
    public ?string $image = null;

    #[ORM\Column(length: 255, nullable: false)]
    public ?string $slug;

    #[ORM\OneToMany(targetEntity: Season::class, 
                    mappedBy: 'serie_id', 
                    orphanRemoval: true,
                    fetch: 'EAGER')]
    private Collection $seasons;

    #[ORM\Column(nullable: true)]
    private ?int $tmdb_id = null;    

    public function __construct(
        #[ORM\Column]
        public string $name)
    {
        $this->setSlug();
        $this->seasons = new ArrayCollection();
    }

    public function setSlug(): static
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->name)));
        $this->slug = $slug;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImbdScore(): ?float
    {
        return $this->imbd_score;
    }

    public function setImbdScore(?float $imbd_score): static
    {
        $this->imbd_score = $imbd_score;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getCategorys(): ?string
    {
        return $this->categorys;
    }

    public function setCategorys(?string $categorys): static
    {
        $this->categorys = $categorys;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Seasons>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): static
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->setSerieId($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): static
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getSerieId() === $this) {
                $season->setSerieId(null);
            }
        }

        return $this;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdb_id;
    }

    public function setTmdbId(?int $tmdb_id): static
    {
        $this->tmdb_id = $tmdb_id;

        return $this;
    }
}

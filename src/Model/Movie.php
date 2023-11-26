<?php

namespace App\Model;

use App\Validator as AppAssert;

final class Movie
{
    public const URL_IMAGE_DEFAULT_VALUE = 'images/image_not_found.png';

    private string $id;
    private string $title;
    private ?int $releaseYear = null;
    private ?float $averageRating = null;
    private ?int $numVotes = null;
    #[AppAssert\ImageExists]
    private ?string $urlImage;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(?int $releaseYear): self
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getUrlImage(): ?string
    {
        return $this->urlImage;
    }

    public function setUrlImage(?string $urlImage): self
    {
        $this->urlImage = $urlImage;

        return $this;
    }

    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    public function setAverageRating(?float $averageRating): self
    {
        $this->averageRating = $averageRating;

        return $this;
    }

    public function getNumVotes(): ?int
    {
        return $this->numVotes;
    }

    public function setNumVotes(?int $numVotes): self
    {
        $this->numVotes = $numVotes;

        return $this;
    }
}
